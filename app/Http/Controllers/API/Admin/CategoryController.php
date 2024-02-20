<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\CategoryServiceInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\DeleteCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends BaseController
{
    protected $categoryService;

    /**
     * create a new instance
     *
     * @param CategoryServiceInterface $categoryService
     */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * get categories list
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
        list($statusCode, $data) = $this->categoryService->getAllCategories($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail category
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->categoryService->detailCategory($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create category
     * @param  CreateCategoryRequest $request
     *
     * @return json
     */
    public function create(CreateCategoryRequest $request)
    {
        list($statusCode, $data) = $this->categoryService->createCategory($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * update category
     * @param  UpdateCategoryRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['_method'] = 'patch';
        list($statusCode, $data) = $this->categoryService->updateCategory($data);

        return $this->response($data, $statusCode);
    }

    /**
     * delete category
     * @param  int $id
     *
     * @return json
     */
    public function delete($id)
    {

        list($statusCode, $data) = $this->categoryService->deleteCategory($id);

        return $this->response($data, $statusCode);
    }
}
