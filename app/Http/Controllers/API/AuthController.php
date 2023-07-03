<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\LoginRequest;
use App\Services\AuthServiceInterface;
use App\Http\Requests\ConfirmTokenRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;



class AuthController extends BaseController
{
    protected $authService;

    /**
     * Create a new instance
     *
     * @param AuthServiceInterface $authService
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Post login
     *
     * @param LoginRequest $request
     * @return json
     */
    public function login(LoginRequest $request)
    {
        list($statusCode, $data) = $this->authService->login($request->all());
        return $this->response($data, $statusCode);
    }

    /**
     * patch changePasswordFirstLogin
     *
     * @param ChangePasswordRequest $request
     * @return json
     */
    public function changePasswordFirstLogin(ChangePasswordRequest $request)
    {
        list($statusCode, $data) = $this->authService->changePassword($request->all());
        return $this->response($data, $statusCode);
    }

    /**
     * delete logout
     *
     * @return json
     */
    public function logout()
    {
        list($statusCode, $data) = $this->authService->logout();
        return $this->response($data, $statusCode);
    }

    /**
     * Patch reset password
     *
     * @param ResetPasswordRequest $request
     * @return json
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        list($statusCode, $data) = $this->authService->resetPassword($request->all());
        return response($data, $statusCode);
    }

    /**
     * Get confirm token reset password
     *
     * @param ConfirmTokenRequest $request
     * @return json
     */
    public function confirmResetPasswordToken(ConfirmTokenRequest $request)
    {
        list($statusCode, $data) = $this->authService->confirmResetPasswordToken($request->all());
        return response($data, $statusCode);
    }

    /**
     * forgotPassword function
     *
     * @param ForgotPasswordRequest $request
     * @return json
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        list($statusCode, $data) = $this->authService->forgotPassword($request->all());

        return $this->response($data, $statusCode);
    }
}
