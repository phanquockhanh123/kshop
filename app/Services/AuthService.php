<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\PasswordReset;
use Illuminate\Http\Response;
use App\Mail\MailResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService implements AuthServiceInterface
{
    /**
     * Login function for admin
     *
     * @param array $params
     * @return array
     */
    public function login(array $params)
    {
        
        switch ($params['grant_type']) {
            case config('const.grant_type.password'):
                // login
                if (
                    !Auth::guard('admin')->attempt([
                        'email_address' => $params['email_address'],
                        'password' => $params['password'],
                    ])
                ) {
                    return [Response::HTTP_BAD_REQUEST, [
                        'message' => trans('messages.MsgErr015'),
                    ]];
                }
                $admin = Admin::where('email_address', $params['email_address'])
                    ->whereNull('deleted_at')->first();
                // check status
                if ($admin->status == Admin::STATUS_DEACTIVATED) {
                    return [Response::HTTP_BAD_REQUEST, [
                        'message' => trans('messages.MsgErr035'),
                    ]];
                }
                break;
            case config('const.grant_type.refresh_token'):
                $admin = Admin::where('refresh_token', $params['refresh_token'])
                    ->whereNull('deleted_at')->first();
                if (empty($admin)) {
                    return [Response::HTTP_REQUEST_TIMEOUT, ['message' => [trans('auth.failed')]]];
                }
                if ($admin->status == Admin::STATUS_DEACTIVATED) {
                    return [Response::HTTP_BAD_REQUEST, [
                        'message' => trans('messages.MsgErr035'),
                    ]];
                }
                if (now()->gt($admin->refresh_token_expired_at)) {
                    return [Response::HTTP_REQUEST_TIMEOUT, ['message' => [trans('auth.failed')]]];
                }
                break;
        }
        DB::beginTransaction();
        try {
            // delete all access token of admin
            $admin->tokens()->delete();

            // create new access token
            $accessToken = $admin->createToken('adminToken-' . $admin->id, ['role:admin'])->plainTextToken;

            // update admin
            $refreshToken = generateHashToken();
            $admin->update([
                'refresh_token' => $refreshToken,
                'refresh_token_expired_at' => now()->addMinutes(config('const.refresh_token_lifetime')),
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::error($th);
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => [trans('auth.failed')]]];
        }
        return [Response::HTTP_OK, [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'admin_id' => $admin->id,
            'role' => $admin->role,
            'first_login_flag' => $admin->first_login_flag,
        ]];
    }

    /**
     * changePassword function for admin
     *
     * @param array $request
     * @return array
     */
    public function changePassword($request)
    {
        $admin = auth()->user();
        try {
            if (!$admin->first_login_flag) {
                $admin->update([
                    'password' => Hash::make($request['password']),
                    'first_login_flag' => true,
                ]);
            }
            if ($admin->first_login_flag) {
                $admin->update([
                    'password' => Hash::make($request['password']),
                ]);
            }
        } catch (\Throwable $th) {
            \Log::error($th);
            return [
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [
                    'message' => trans('messages.MsgErr006')
                ]
            ];
        }
        return [Response::HTTP_NO_CONTENT, []];
    }

    /**
     * Reset password for admin
     *
     * @param array $params
     * @return array
     */
    public function resetPassword(array $params)
    {
        // Check token existence
        $passwordReset = PasswordReset::where('token', $params['token'])->first();
        if (empty($passwordReset)) {
            return [Response::HTTP_BAD_REQUEST, ['message' => [trans('passwords.token')]]];
        }

        //Check expired token
        if ($passwordReset->updated_at->lt(now()->subMinutes(config('auth.passwords.users.expire')))) {
            return [Response::HTTP_BAD_REQUEST, ['message' => [trans('messages.token_expired')]]];
        }

        //Check email
        $admin = Admin::where('email_address', $passwordReset->email)->first();
        if (empty($admin)) {
            return [Response::HTTP_BAD_REQUEST, ['message' => [sprintf(trans('messages.MsgErr021'), 'Email')]]];
        }

        DB::beginTransaction();
        try {
            //Reset password
            $admin->update([
                'password' => Hash::make($params['password']),
            ]);

            //Delete token
            $passwordReset->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th);
            return [
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [
                    'message' => trans('messages.MsgErr006')
                ]
            ];
        }
        return [Response::HTTP_OK, []];
    }

    /**
     * Confirm reset password token
     *
     * @param array $params
     * @return array
     */
    public function confirmResetPasswordToken(array $params)
    {
        //Check token existence
        $passwordReset = PasswordReset::where('token', $params['token'])->first();
        if (empty($passwordReset)) {
            return [Response::HTTP_BAD_REQUEST, ['message' => [trans('passwords.token')]]];
        }

        //Check expired token
        if ($passwordReset->updated_at->lt(now()->subMinutes(config('auth.passwords.users.expire')))) {
            return [Response::HTTP_OK, ['message' => [trans('messages.token_expired')]]];
        }
        return [Response::HTTP_OK, ['message' => [trans('messages.token_valid')]]];
    }

    /**
     * Forgot password function for admin
     *
     * @param array $params
     * @return array
     */
    public function forgotPassword(array $params)
    {
        try {
            $admin = Admin::where('email_address', $params['email_address'])
                ->where('status', Admin::STATUS_ACTIVE)
                ->whereNull('deleted_at')
                ->first();
            // check admin exists in db or active
            if (!$admin) {
                // admin not exists or disactive
                return [Response::HTTP_BAD_REQUEST, ['message' => [sprintf(trans('messages.MsgErr021'), 'Email')]]];
            }

            // update or create PasswordReset
            $passwordReset = PasswordReset::updateOrCreate(
                ['email' => $params['email_address']],
                ['token' => generateHashToken()]
            );

            // Send url reset password to email
            Mail::queue(new MailResetPassword($passwordReset));
        } catch (\Exception $error) {
            \Log::error($error);
            dd($error);
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => trans('messages.MsgErr006')]];
        }

        return [Response::HTTP_NO_CONTENT, []];
    }

    /**
     * Logout function for admin
     *
     * @return array
     */
    public function logout()
    {
        $admin = auth()->user();

        DB::beginTransaction();
        try {
            $admin->tokens()->delete();
            $admin->update([
                'refresh_token_expired_at' => Carbon::yesterday(),
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::error($th);
            return [
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [
                    'message' => trans('messages.MsgErr006')
                ]
            ];
        }
        return [Response::HTTP_NO_CONTENT, []];
    }
}