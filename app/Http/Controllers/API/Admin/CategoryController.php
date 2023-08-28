<?php

namespace App\Http\Controllers\API\Admin;

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
    public function index()
    {
        list($statusCode, $data) = $this->categoryService->getAllCategories();

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
        list($statusCode, $data) = $this->categoryService->updateCategory($data);

        return $this->response($data, $statusCode);
    }

    /**
     * delete category
     * @param  DeleteCategoryRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function delete(DeleteCategoryRequest $request)
    {
        
        list($statusCode, $data) = $this->categoryService->deleteCategories($request->all());

        return $this->response($data, $statusCode);
    }
}
