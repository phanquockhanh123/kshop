<?php

namespace App\Services;

interface DiscountServiceInterface
{
    public function getAllDiscounts();

    public function detailDiscount($id);

    public function deleteDiscount($id);

    public function createDiscount($params);

    public function updateDiscount($params);
}
