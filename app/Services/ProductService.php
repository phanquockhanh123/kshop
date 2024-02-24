<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
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
        $nextAutoIncrement = Product::next();

        $tags = Str::slug($data['name']) . '-' . $nextAutoIncrement;
        $sku = str_replace(' ', '', $data['name']) . '-' . Str::uuid(time());

        $dataProduct = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'image' => [],
            'sku' => $sku,
            'tags' => $tags,
            'description' => $data['description'] ?? '',
            'priority' => $data['priority'],
            'supplier' => $data['supplier'],
            'price' => $data['price'],
            'price_compare' => $data['price_compare'],
            'is_ship' => $data['is_ship'],
            'weight' => $data['weight']
        ];

        $dataProductInfos = [
            'color_id' => $data['color_id'],
            'price_more' => $data['price_more'],
            'size_id' => $data['size_id'],
            'quantity' => $data['quantity'],
            'quantity_avail' => $data['quantity_avail'] ?? 0,
        ];

        if (!empty($data['image'])) {
            foreach ($data['image'] as $image) {
                $dataProduct = uploadManyImage($image, '/img/products', $dataProduct);
            }
        }

        try {
            $dataSave['status'] = Product::STATUS_ACTIVE;
            if (!empty($data['campaign_id'])) {
                $dataProduct['campaign_id'] = $dataSave['campaign_id'];
            }

            if (!empty($data['discount_id'])) {
                $dataProduct['discount_id'] = $dataSave['discount_id'];
            }

            $product = Product::create($dataProduct);
            $dataProductInfos['product_id'] = $product->id;

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
