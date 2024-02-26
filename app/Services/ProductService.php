<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductInfos;
use Illuminate\Support\Facades\DB;
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
        $query = Product::with('productInfos');

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
            $Product = Product::with('productInfos')->findOrFail($ProductId);
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
            DB::beginTransaction();
            if ($product) {
                $product->delete();
                ProductInfos::where('product_id', $product->id)->delete();
                DB::commit();
                return [Response::HTTP_OK, ['message' => 'This record has deleted.']];
            } else {
                DB::rollBack();
                return [Response::HTTP_BAD_REQUEST, [
                    'message' => 'This record not found.'
                ]];
            }
        } catch (\Exception $e) {
            dd($e);
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }
    }

    public function createProduct($data)
    {
        $nextAutoIncrement = Product::next();

        $tags = Str::slug($data['name']) . '-' . $nextAutoIncrement;

        $dataProduct = [
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'image' => [],
            'tags' => $tags,
            'description' => $data['description'] ?? '',
            'priority' => $data['priority'],
            'supplier' => $data['supplier'],
            'price' => $data['price'],
            'price_compare' => $data['price_compare'],
            'is_ship' => $data['is_ship'],
            'weight' => $data['weight']
        ];

        if (!empty($data['image'])) {
            foreach ($data['image'] as $image) {
                $dataProduct = uploadManyImage($image, '/img/products', $dataProduct);
            }
        }
        DB::beginTransaction();
        try {
            $dataSave['status'] = Product::STATUS_ACTIVE;
            if (!empty($data['campaign_id'])) {
                $dataProduct['campaign_id'] = $dataSave['campaign_id'];
            }

            if (!empty($data['discount_id'])) {
                $dataProduct['discount_id'] = $dataSave['discount_id'];
            }
            $product = Product::create($dataProduct);

            foreach ($data['size_id'] as $sizeId) {
                foreach ($data['color_id'] as $colorId) {
                    $dataProductInfos[] = [
                        'price_more' => $data['price_more'],
                        'quantity' => $data['quantity'],
                        'quantity_avail' => $data['quantity_avail'] ?? 0,
                        'size_id' => $sizeId,
                        'color_id' => $colorId,
                        'product_id' => $product->id,
                        'sku' => str_replace(' ', '', $data['name']) . '-' . Str::uuid(time())
                    ];
                }
            }

            foreach ($dataProductInfos as $dataProductInfo) {
                ProductInfos::create($dataProductInfo);
            }
            DB::commit();
            return [Response::HTTP_OK, ['message' => 'Product created successfully.']];
           
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }

    /**
     * update product
     * @param  $data
     * @return array
     */
    public function updateProduct($data)
    {
        $product = Product::findOrFail($data['id']);
        $dataSave = $data;
        $dataSave['image'] = $product->image;

        if (!empty($data['image'])) {
            foreach ($data['remove_images'] ?? [] as $image) {
                deleteImageLocalStorage($image);
            }

            foreach ($data['image'] as $image) {
                $dataSave = uploadManyImage($image, '/img/products', $dataSave);
            }

            foreach ($dataSave['image'] as $key => $image) {
                if (in_array($image, $data['remove_images'] ?? [])) {
                    unset($dataSave['image'][$key]);
                }
            }
            $dataSave['image'] = array_values($dataSave['image']);
        }

        DB::beginTransaction();
        try {
            $product->update($dataSave);
            ProductInfos::where('product_id', $product->id)->forceDelete();

            foreach ($data['size_id'] as $sizeId) {
                foreach ($data['color_id'] as $colorId) {
                    $dataProductInfos[] = [
                        'size_id' => $sizeId,
                        'color_id' => $colorId,
                        'price_more' => $data['price_more'],
                        'quantity' => $data['quantity'],
                        'product_id' => $product->id,
                        'sku' => str_replace(' ', '', $data['name']) . '-' . Str::uuid(time())
                    ];
                }
            }

            foreach ($dataProductInfos as $dataProductInfo) {
                ProductInfos::create($dataProductInfo);
            }
            DB::commit();
            return [Response::HTTP_OK, ['message' => 'Product updated successfully.']];
           
        } catch (\Exception $e) {
            DB::rollback();
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }

        return [Response::HTTP_OK, []];
    }



}
