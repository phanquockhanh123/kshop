<?php

namespace App\Services;

use App\Models\Color;
use App\Http\Resources\ColorResource;
use Symfony\Component\HttpFoundation\Response;

class ColorService implements ColorServiceInterface
{

    /**
     * getAllColors function
     *
     * @return array
     */
    public function getAllColors(array $filter, array $paginate,)
    {
        $query = Color::query();

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
     * create Color
     * @param  $data
     * @return array
     */
    public function createColor($data)
    {
        try {
            $data['status'] = Color::STATUS_ACTIVE;
            Color::create($data);
            return [Response::HTTP_OK, ['message' => 'Color created successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update Color
     * @param  $data
     * @return array
     */
    public function updateColor($data)
    {
        $Color = Color::findOrFail($data['id']);

        try {
            $Color->update($data);
            return [Response::HTTP_OK, ['message' => 'Color updated successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * detail Color
     * @param int $id
     * @return array
     */
    public function detailColor($id)
    {
        $Color = Color::findOrFail($id);
        $data = (new ColorResource($Color))->toArray();
        return [Response::HTTP_OK, $data];
    }

    /**
     * delete Color
     * @param  $id
     * @return array
     */
    public function deleteColor($id)
    {
        try {
            $Color = Color::find($id);
            if ($Color) {
                $Color->delete();
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
