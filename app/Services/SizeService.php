<?php

namespace App\Services;

use Carbon\Carbon;

use App\Models\Size;
use App\Models\Category;
use App\Http\Resources\SizeResource;
use App\Http\Resources\CategoryResource;
use Symfony\Component\HttpFoundation\Response;

class SizeService implements SizeServiceInterface
{

    /**
     * getAllSizes function
     *
     * @return array
     */
    public function getAllSizes(array $filter, array $paginate,)
    {
        $query = Size::query();

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
     * create size
     * @param  $data
     * @return array
     */
    public function createSize($data)
    {
        try {
            $data['status'] = Size::STATUS_ACTIVE;
            Size::create($data);
            return [Response::HTTP_OK, ['message' => 'Size created successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update size
     * @param  $data
     * @return array
     */
    public function updateSize($data)
    {
        $size = Size::findOrFail($data['id']);

        try {
            $size->update($data);
            return [Response::HTTP_OK, ['message' => 'Size updated successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * detail size
     * @param int $id
     * @return array
     */
    public function detailSize($id)
    {
        $size = Size::findOrFail($id);
        $data = (new SizeResource($size))->toArray();
        return [Response::HTTP_OK, $data];
    }

    /**
     * delete size
     * @param  $id
     * @return array
     */
    public function deleteSize($id)
    {
        try {
            $size = Size::find($id);
            if ($size) {
                $size->delete();
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
