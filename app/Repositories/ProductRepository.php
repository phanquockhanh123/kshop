<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    /**
     *  @param Product $model
     *
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function create($data) {
        return $this->model->create($data);
    }

    public function getAll() {
        return $this->model->get();
    }

    public function detail($id) {
        return $this->model->find($id);
    }

    public function delete($id) {
        return $this->model->where('id', $id)->delete();
    }
}
