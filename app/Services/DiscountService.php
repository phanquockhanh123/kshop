<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;

use App\Models\Discount;
use Illuminate\Support\Str;
use App\Http\Resources\DiscountResource;
use App\Repositories\DiscountRepository;
use Symfony\Component\HttpFoundation\Response;

class DiscountService implements DiscountServiceInterface
{

    /**
     * getAllDiscounts function
     *
     * @return array
     */
    public function getAllDiscounts(array $filter, array $paginate)
    {
        $query = Discount::query();

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
     * get detail discount function
     *
     * @return array
     */
    public function detailDiscount($discountId)
    {
        try {
            $discount = Discount::findOrFail($discountId);
            $data = (new DiscountResource($discount))->toArray();
            return [Response::HTTP_OK, $data];
        } catch (Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['errors' => $e]];
        }
    }

    /**
     * delete discount function
     *
     * @return array
     */
    public function deleteDiscount($discountId)
    {
        try {
            $discount = Discount::find($discountId);
            if ($discount) {
                $discount->delete();
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

    /**
     * create discount function
     *
     * @return array
     */
    public function createDiscount($data)
    {
        try {
            $data['status'] = Discount::STATUS_ACTIVE;
            $data['discount_code'] = Str::random();
            Discount::create($data);
            return [Response::HTTP_OK, ['message' => 'Discount created successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update discount
     * @param  $data
     * @return array
     */
    public function updateDiscount($data)
    {
        $discount = Discount::findOrFail($data['id']);

        try {
            $discount->update($data);
            $data['discount_code'] = Str::random();
            return [Response::HTTP_OK, ['message' => 'Discount updated successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }
}
