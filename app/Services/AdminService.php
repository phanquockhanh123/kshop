<?php

namespace App\Services;

use Exception;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\AdminResource;
use Symfony\Component\HttpFoundation\Response;

class AdminService implements AdminServiceInterface
{

    /**
     * get All Admins function
     *
     * @return array
     */
    public function getAllAdmins(array $filter,array $paginate)
    {
        $query = Admin::query();

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
     * get detail Admin function
     *
     * @return array
     */
    public function detailAdmin($AdminId)
    {
        try {
            $Admin = Admin::findOrFail($AdminId);
            $data = (new AdminResource($Admin))->toArray();
            return [Response::HTTP_OK, $data];
        } catch (Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['errors' => $e]];
        }
    }

    /**
     * delete Admin function
     *
     * @return array
     */
    public function deleteAdmin($adminId)
    {
        try {
            $admin = Admin::find($adminId);
            if ($admin) {
                $admin->delete();
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

    public function createAdmin($data) {
        $dataSave = $data;

        if (!empty($data['image'])) {
            $image = uploadImage($data['image'], '/img/Admins');
           
            $dataSave['image'] = $image;
        }
        DB::beginTransaction();
        try {
            $dataSave['status'] = Admin::STATUS_ACTIVE;
            $dataSave['code'] = \Str::random(15);

            Admin::create($dataSave);
            DB::commit();
            return [Response::HTTP_OK, ['message' => 'Admin created successfully.']];
        } catch (\Exception $e) {
            DB::rollback();
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update Admin
     * @param  $data
     * @return array
     */
    public function updateAdmin($data)
    {
        $Admin = Admin::findOrFail($data['id']);
        $dataSave = $data;

        if (!empty($data['image'])) {
            deleteImageLocalStorage($Admin->image);
            $image = uploadImage($data['image'], '/img/Admins');

            $dataSave['image'] = $image;
        }
        DB::beginTransaction();
        try {
            $Admin->update($dataSave);
            DB::commit();
            return [Response::HTTP_OK, ['message' => 'Admin updated successfully.']];
        } catch (\Exception $e) {
            DB::rollBack();
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
