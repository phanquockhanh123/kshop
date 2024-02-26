<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\AdminServiceInterface;
use App\Http\Requests\CreateAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Controllers\API\BaseController;

class AdminController extends BaseController
{
    protected $adminService;

    /**
     * create a new instance
     *
     * @param AdminServiceInterface $adminService
     */
    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * get Admin list
     *
     * @return json
     */
    public function index(Request $request)
    {
        $request->validate([
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'sort_fields' => 'nullable|string|in:created_at,updated_at',
            'sort_order' => 'nullable|string|in:desc,asc'
        ]);

        $params = $request->all();
        $paginate = [
            'page' => $params['page'] ?? 1,
            'per_page' => $params['per_page'] ?? 8
        ];

        $filter = [
            'sort_fields' => $params['sort_fields'] ?? null,
            'sort_order' => $params['sort_order'] ?? 'ASC',
        ];
        list($statusCode, $data) = $this->adminService->getAllAdmins($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail Admin
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->adminService->detailAdmin($id);

        return $this->response($data, $statusCode);
    }

    /**
     * delete Admin
     * @param  int $id
     *
     * @return json
     */
    public function delete(int $id)
    {
        list($statusCode, $data) = $this->adminService->deleteAdmin($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create Admin
     * @param CreateAdminRequest $request
     *
     * @return json
     */
    public function create(CreateAdminRequest $request)
    {
        list($statusCode, $data) = $this->adminService->createAdmin($request->all());
        return $this->response($data, $statusCode);
    }

     /**
     * update Admin
     * @param  UpdateAdminRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateAdminRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['_method'] = 'patch';

        list($statusCode, $data) = $this->adminService->updateAdmin($data);

        return $this->response($data, $statusCode);
    }
}
