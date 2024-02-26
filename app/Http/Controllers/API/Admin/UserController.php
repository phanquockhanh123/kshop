<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserServiceInterface;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;

    /**
     * create a new instance
     *
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * get user list
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
        list($statusCode, $data) = $this->userService->getAllUsers($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail User
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->userService->detailUser($id);

        return $this->response($data, $statusCode);
    }

    /**
     * delete User
     * @param  int $id
     *
     * @return json
     */
    public function delete(int $id)
    {
        list($statusCode, $data) = $this->userService->deleteUser($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create User
     * @param CreateUserRequest $request
     *
     * @return json
     */
    public function create(CreateUserRequest $request)
    {
        list($statusCode, $data) = $this->userService->createUser($request->all());
        return $this->response($data, $statusCode);
    }

     /**
     * update User
     * @param  UpdateUserRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['_method'] = 'patch';

        list($statusCode, $data) = $this->userService->updateUser($data);

        return $this->response($data, $statusCode);
    }
}
