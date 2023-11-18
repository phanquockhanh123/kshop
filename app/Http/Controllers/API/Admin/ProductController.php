<?php

namespace App\Http\Controllers\API\Admin;

use App\Services\ProductServiceInterface;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\API\BaseController;


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
     * get products list
     *
     * @return json
     */
    public function index()
    {
        list($statusCode, $data) = $this->productService->getAllProducts();

        return $this->response($data, $statusCode);
    }

    /**
     * detail product
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
     * create product
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
     * delete product
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
     * update product
     * @param  UpdateProductRequest $request
     * @param  int $id
     *
     * @return json
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $data = $request->all();
 
        $data['id'] = $id;
        
        list($statusCode, $data) = $this->productService->updateProduct($data);

        return $this->response($data, $statusCode);
    }
}
