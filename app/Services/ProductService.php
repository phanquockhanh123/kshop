<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductInfos;
use App\Http\Resources\ProductResource;
use Symfony\Component\HttpFoundation\Response;

class ProductService implements ProductServiceInterface
{

    /**
     * get All Products function
     *
     * @return array
     */
    public function getAllProducts(array $filter, array $paginate)
    {
        $query = Product::query();

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
     * get detail Product function
     *
     * @return array
     */
    public function detailProduct($ProductId)
    {
        try {
            $Product = Product::findOrFail($ProductId);
            $data = (new ProductResource($Product))->toArray();
            return [Response::HTTP_OK, $data];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['errors' => $e]];
        }
    }

    /**
     * delete Product function
     *
     * @return array
     */
    public function deleteProduct($productId)
    {
        try {
            $product = Product::with('productInfos')->find($productId);

            if ($product) {
                $product->delete();
                $product->productInfos->delete();
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

    public function createProduct($data)
    {
        $dataSave = $data;

        if (!empty($data['image'])) {
            $image = uploadImage($data['image'], '/img/products');

            $dataSave['image'] = $image;
        }

        try {
            $productDB = Product::where('name', $dataSave['name'])->first();

            $dataSave['status'] = Product::STATUS_ACTIVE;
            if (!empty($data['campaign_id'])) {
                $dataProduct['campaign_id'] = $dataSave['campaign_id'];
            }

            if (!empty($data['discount_id'])) {
                $dataProduct['discount_id'] = $dataSave['discount_id'];
            }
            $dataProduct = [
                'category_id' => $dataSave['category_id'],
                'name' => $dataSave['name'],
                'image' => $dataSave['image'],
                'description' => $dataSave['description'] ?? '',
                'status' => $dataSave['status'],
                'priority' => $dataSave['priority'],
            ];

            $dataProductInfos = [
                'color_id' => $dataSave['color_id'],
                'price' => $dataSave['price'],
                'size_id' => $dataSave['size_id'],
                'quantity' => $dataSave['quantity'],
            ];

            if (empty($productDB)) {
                $product = Product::create($dataProduct);
                $dataProductInfos['product_id'] = $product->id;
            } else {
                $dataProductInfos['product_id'] = $productDB->id;
            }

            ProductInfos::create($dataProductInfos);
            return [Response::HTTP_OK, ['message' => 'Product created successfully.']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update Product
     * @param  $data
     * @return array
     */
    public function updateProduct($data)
    {

        return [Response::HTTP_OK, []];
    }
}
