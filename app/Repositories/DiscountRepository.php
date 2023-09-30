<?php

namespace App\Repositories;

use App\Models\Discount;

class DiscountRepository extends BaseRepository
{
    /**
     *  @param Discount $model
     *
     */
    public function __construct(Discount $model)
    {
        $this->model = $model;
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

    public function create($data) {
        return $this->model->create($data);
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
