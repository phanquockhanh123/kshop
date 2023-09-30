<?php

namespace App\Http\Controllers\API\Admin;

use App\Services\DiscountServiceInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

class DiscountController extends BaseController
{
    protected $discountService;

    /**
     * create a new instance
     *
     * @param DiscountServiceInterface $discountService
     */
    public function __construct(DiscountServiceInterface $discountService)
    {
        $this->discountService = $discountService;
    }

    /**
     * get discounts list
     *
     * @return json
     */
    public function index()
    {
        list($statusCode, $data) = $this->discountService->getAllDiscounts();

        return $this->response($data, $statusCode);
    }

    /**
     * detail discount
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->discountService->detailDiscount($id);

        return $this->response($data, $statusCode);
    }

    /**
     * delete discount
     * @param  int $id
     *
     * @return json
     */
    public function deleteDiscount(int $id)
    {
        list($statusCode, $data) = $this->discountService->deleteDiscount($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create discount
     * @param CreateDiscountRequest $request
     *
     * @return json
     */
    public function create(CreateDiscountRequest $request)
    {
        list($statusCode, $data) = $this->discountService->createDiscount($request->all());

        return $this->response($data, $statusCode);
    }

    /**
     * update discount
     * @param  UpdateDiscountRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateDiscountRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        list($statusCode, $data) = $this->discountService->updateDiscount($data);

        return $this->response($data, $statusCode);
    }

}
