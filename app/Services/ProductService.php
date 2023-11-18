<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    /**
     * create a new instance
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct($data) {

        // Lưu ảnh
        if (!empty($data['filepath'])) {
            $profile = $data['filepath'];
            $filename = time() . '_' . $profile->getClientOriginalName();

            $uploadPath = public_path('/assests/img/products');

            // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true, true);
            }

            if (move_uploaded_file($profile, $uploadPath . '/' . $filename)) {
                $data['filepath'] = $uploadPath . '/' . $filename;
                $data['photo_name'] = $filename;
            } else {
                return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
            }
        }

        try {
            $this->productRepository->create($data);
            return [Response::HTTP_OK, ['message' => 'Create product successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }
    }

    public function getAllProducts() {
        $products = $this->productRepository->getAll();
        return [Response::HTTP_OK, $products];
    }

    /**
     * get detail product function
     *
     * @return array
     */
    public function detailProduct($productId)
    {
        $product = $this->productRepository->detail($productId);
        return [Response::HTTP_OK, $product];
    }

    /**
     * delete product function
     *
     * @return array
     */
    public function deleteProduct($productId)
    {
        $product = Product::where('id', $productId)->first();
        if (empty($product)) {
            return [Response::HTTP_BAD_REQUEST, ['message' => 'Product not exists!']];
        }
        try {
            $this->productRepository->delete($productId);
            return [Response::HTTP_OK, ['message' => 'Delete product successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => $e]];
        }
        
    }

    /**
     * update product
     * @param  $data
     * @return array
     */
    public function updateProduct($data)
    {
        $product = Product::where('id', $data['id'] ?? '')->first();

        if (empty($product)) {
            return [Response::HTTP_BAD_REQUEST, ['message' => 'Product not exists!']];
        }
        // Lưu ảnh
        if (!empty($data['filepath'])) {

            $profile = $data['filepath'];
            $filename = time() . '_' . $profile->getClientOriginalName();

            $uploadPath = public_path('/assests/img/products') ;
            $imagePath = $uploadPath . '/' . $filename;
            // Kiểm tra xem thư mục đã tồn tại chưa, nếu không thì tạo mới
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true, true);
            }

            if ($product->filepath) {
                unlink($product->filepath);
            }

            if (move_uploaded_file($profile, $imagePath)) {
                $data['filepath'] = $imagePath;
                $data['photo_name'] = $filename;
            } else {
                return [Response::HTTP_INTERNAL_SERVER_ERROR, ['message' => 'Upload file local fail!']];
            }
        }
        dd($data);
        try {
            $this->productRepository->edit($data);
            return [Response::HTTP_OK, ['message' => 'Update product successful!']];
        } catch (\Exception $e) {
            return [Response::HTTP_INTERNAL_SERVER_ERROR, $e];
        }
    }
}
