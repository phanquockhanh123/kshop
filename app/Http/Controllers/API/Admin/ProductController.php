<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Services\ProductServiceInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends BaseController
{
    protected $productService;

    /**
     * create a new instance
     *
     * @param ProductServiceInterface $productService
     */
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    /**
     * get Products list
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
        list($statusCode, $data) = $this->productService->getAllProducts($filter, $paginate);

        return $this->response($data, $statusCode);
    }

    /**
     * detail Product
     * @param  int $id
     *
     * @return json
     */
    public function detail(int $id)
    {
        list($statusCode, $data) = $this->productService->detailProduct($id);

        return $this->response($data, $statusCode);
    }

    /**
     * delete Product
     * @param  int $id
     *
     * @return json
     */
    public function deleteProduct(int $id)
    {
        list($statusCode, $data) = $this->productService->deleteProduct($id);

        return $this->response($data, $statusCode);
    }

    /**
     * create Product
     * @param CreateProductRequest $request
     *
     * @return json
     */
    public function create(CreateProductRequest $request)
    {
        list($statusCode, $data) = $this->productService->createProduct($request->all());

        return $this->response($data, $statusCode);
    }

     /**
     * update Product
     * @param  UpdateProductRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->all();
        $data['id'] = $id;
        $data['_method'] = 'patch';

        list($statusCode, $data) = $this->productService->updateProduct($data);

        return $this->response($data, $statusCode);
    }
}
