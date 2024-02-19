<?php

namespace App\Http\Controllers\API\Admin;

use App\Services\DiscountServiceInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use Illuminate\Http\Request;

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
        list($statusCode, $data) = $this->discountService->getAllDiscounts($filter, $paginate);

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
