<?php

namespace App\Services;

interface ProductServiceInterface
{
    public function createProduct($params);

    public function getAllProducts();

    public function detailProduct($id);

    public function deleteProduct($id);

    public function updateProduct($data);
}
