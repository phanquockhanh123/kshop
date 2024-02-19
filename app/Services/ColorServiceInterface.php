<?php

namespace App\Services;

interface ColorServiceInterface
{
    public function getAllColors(array $filter, array $paginate);

    public function createColor($params);

    public function detailColor($id);

    public function updateColor($params);

    public function deleteColor($id);
}
