<?php

namespace App\Services;

interface CategoryServiceInterface
{
    public function getAllCategories(array $filter, array $paginate);

    public function createCategory($params);

    public function detailCategory($id);

    public function updateCategory($params);

    public function deleteCategory($id);
}
