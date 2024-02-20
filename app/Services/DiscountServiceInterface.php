<?php

namespace App\Services;

interface DiscountServiceInterface
{
    public function getAllDiscounts(array $filter, array $paginate);

    public function detailDiscount($id);

    public function deleteDiscount($id);

    public function createDiscount($params);

    public function updateDiscount($params);
}
