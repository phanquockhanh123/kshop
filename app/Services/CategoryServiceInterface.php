<?php

namespace App\Services;

interface CategoryServiceInterface
{
    public function getAllCategories();

    public function createCategory($params);

    public function detailCategory($id);

    public function updateCategory($params);

    public function deleteCategories($params);

    public function deleteCategory($id);
}
