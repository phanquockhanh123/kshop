<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Jobs\DelayCreateCampainJob;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserService implements UserServiceInterface
{

    /**
     * get All Users function
     *
     * @return array
     */
    public function getAllUsers(array $filter,array $paginate)
    {
        $query = User::query();

        if (!empty($filter['query'])) {
            $query = $query->whereRaw($filter['query']);
        }

        if ($filter['sort_fields']) {
            $query = $query->orderBy($filter['sort_fields'], $filter['sort_order']);
        }

        $data = $query->orderBy('updated_at', 'DESC')
            ->paginate($paginate['per_page'], ['*'], 'page', $paginate['page']);

        return [Response::HTTP_OK, $data->toArray()];
    }

    /**
     * get detail User function
     *
     * @return array
     */
    public function detailUser($UserId)
    {
        try {
            $User = User::findOrFail($UserId);
            $data = (new UserResource($User))->toArray();
            return [Response::HTTP_OK, $data];
        } catch (Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['errors' => $e]];
        }
    }

    /**
     * delete User function
     *
     * @return array
     */
    public function deleteUser($UserId)
    {
        try {
            $User = User::find($UserId);
            if ($User) {
                $User->delete();
                return [Response::HTTP_OK, ['message' => 'This record has deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, [
                    'message' => 'This record not found.'
                ]];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }

    }

    public function createUser($data) {
        $dataSave = $data;

        if (!empty($data['image'])) {
            $image = uploadImage($data['image'], '/img/users');
           
            $dataSave['image'] = $image;
        }
        DB::beginTransaction();
        try {
            $dataSave['status'] = Admin::STATUS_ACTIVE;
            $dataSave['code'] = \Str::random(15);

            Admin::create($dataSave);
            DB::commit();
            return [Response::HTTP_OK, ['message' => 'User created successfully.']];
        } catch (\Exception $e) {
            DB::rollback();
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update user
     * @param  $data
     * @return array
     */
    public function updateUser($data)
    {
        $user = Admin::findOrFail($data['id']);
        $dataSave = $data;

        if (!empty($data['image'])) {
            deleteImageLocalStorage($user->image);
            $image = uploadImage($data['image'], '/img/users');

            $dataSave['image'] = $image;
        }
        DB::beginTransaction();
        try {
            $user->update($dataSave);
            DB::commit();
            return [Response::HTTP_OK, ['message' => 'User updated successfully.']];
        } catch (\Exception $e) {
            DB::rollBack();
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
