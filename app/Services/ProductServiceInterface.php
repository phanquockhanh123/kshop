<?php

namespace App\Services;

interface ProductServiceInterface
{
    public function getAllProducts(array $filter,array $paginate);

    public function detailProduct($id);

    public function deleteProduct($id);

    public function createProduct($params);

    public function updateProduct($params);
}
