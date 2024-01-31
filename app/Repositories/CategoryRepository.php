<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    /**
     *  @param Category $model
     *
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAll() {
        return $this->model->get();
    }

    /**
     *  @param array $data
     *
     */
    public function add(array $data) {
        return $this->model->create($data);
    }

    /**
     *  @param array $data
     *
     */
    public function detail(int $id) {
        return $this->model->find($id);
    }

    /**
     *  @param array $data
     *
     */
    public function edit(array $data) {
        $obj = $this->model->findOrFail($data['id']);
        return $obj->update($data);
    }
}
