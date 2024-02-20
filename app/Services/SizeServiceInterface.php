<?php

namespace App\Services;

interface SizeServiceInterface
{
    public function getAllSizes(array $filter, array $paginate);

    public function createSize($params);

    public function detailSize($id);

    public function updateSize($params);

    public function deleteSize($id);
}
