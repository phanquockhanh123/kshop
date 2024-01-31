<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepositories extends BaseRepository implements ProductContract
{
    /**
     *  @param Product $model
     *
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}