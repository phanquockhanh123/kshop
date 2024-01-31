<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Category;
use App\Repositories\CategoryContract;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    /**
     * create a new instance
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * getAllCategories function
     *
     * @return array
     */
    public function getAllCategories()
    {
        $categories = $this->categoryRepository->getAll();
        return [Response::HTTP_OK, $categories];
    }

    /**
     * create category
     * @param  $data
     * @return array
     */
    public function createCategory($data)
    {
        try {
            $this->categoryRepository->add($data);
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update category
     * @param  $data
     * @return array
     */
    public function updateCategory($data)
    {
        try {
            $this->categoryRepository->edit($data);
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * delete categories
     * @param  $data
     * @return array
     */
    public function deleteCategories($data)
    {
        try {
            Category::whereIn('id', $data['ids'])->delete();
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * detail category
     * @param int $id
     * @return array
     */
    public function detailCategory($id)
    {
        $category = $this->categoryRepository->detail($id);

        return [Response::HTTP_OK, $category];
    }

    /**
     * delete category
     * @param  $id
     * @return array
     */
    public function deleteCategory($id)
    {
        try {
            $category = Category::where('id', $id);
            if($category->first()) {
                $category->delete();
            } else {
                return [Response::HTTP_BAD_REQUEST, [
                    'message' => 'Dont find this category'
                ]];
            }

        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
