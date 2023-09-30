<?php

namespace App\Services;

use Exception;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Repositories\DiscountRepository;
use Symfony\Component\HttpFoundation\Response;

class DiscountService implements DiscountServiceInterface
{
    protected $discountRepository;

    /**
     * create a new instance
     *
     * @param DiscountRepository $discountRepository
     */
    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepository = $discountRepository;
    }

    /**
     * getAllDiscounts function
     *
     * @return array
     */
    public function getAllDiscounts()
    {
        $discounts = $this->discountRepository->getAll();
        return [Response::HTTP_OK, $discounts];
    }

    /**
     * get detail discount function
     *
     * @return array
     */
    public function detailDiscount($discountId)
    {
        $discount = $this->discountRepository->detail($discountId);
        return [Response::HTTP_OK, $discount];
    }

    /**
     * delete discount function
     *
     * @return array
     */
    public function deleteDiscount($discountId)
    {
        try {
            $discount = $this->discountRepository->delete($discountId);
            return [Response::HTTP_OK, ['message' => 'Delete discount successful!']];
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
        $data['discount_code'] = Str::random();
        try {
            $this->discountRepository->create($data);
            return [Response::HTTP_OK, ['message' => 'Create discount successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }
    }

    /**
     * update discount
     * @param  $data
     * @return array
     */
    public function updateDiscount($data)
    {
        try {
            $this->discountRepository->edit($data);
            return [Response::HTTP_OK, ['message' => 'Update discount successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
