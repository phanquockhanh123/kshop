<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Category;
use App\Repositories\CategoryContract;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryService implements CategoryServiceInterface
{

    /**
     * getAllCategories function
     *
     * @return array
     */
    public function getAllCategories(array $filter, array $paginate,)
    {
        $query = Category::query();

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
     * create category
     * @param  $data
     * @return array
     */
    public function createCategory($data)
    {
        $dataSave = $data;

        if (!empty($data['image'])) {
            $image = uploadImage($data['image'], '/img/categories');
           
            $dataSave['image'] = $image;
        }

        try {
            $dataSave['status'] = Category::STATUS_ACTIVE;
            Category::create($dataSave);
            return [Response::HTTP_OK, ['message' => 'Category created successfully.']];
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
        $category = Category::findOrFail($data['id']);
        $dataSave = $data;

        if (!empty($data['image'])) {
            deleteImageLocalStorage($category->image);
            $image = uploadImage($data['image'], '/img/categories');
           
            $dataSave['image'] = $image;
        }

        try {
            $category->update($dataSave);
            return [Response::HTTP_OK, ['message' => 'Category updated successfully.']];
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
        $category = Category::findOrFail($id);
        $data = (new CategoryResource($category))->toArray();
        return [Response::HTTP_OK, $data];
    }

    /**
     * delete category
     * @param  $id
     * @return array
     */
    public function deleteCategory($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                $category->delete();
                return [Response::HTTP_OK, ['message' => 'This record has deleted.']];
            } else {
                return [Response::HTTP_BAD_REQUEST, [
                    'message' => 'This record not found.'
                ]];
            }
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
