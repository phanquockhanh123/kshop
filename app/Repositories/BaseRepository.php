<?php

namespace App\Repositories;

use Illuminate\Support\Str;

class BaseRepository
{
    /**
     * @var Illuminate\Database\Eloquent\Model $model
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Illuminate\Database\Eloquent\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /*
    |--------------------------------------------------------------------------
    | These functions below is a wrapper of model's basic functions
    |--------------------------------------------------------------------------
    */

    /**
     * find all
     *
     * @param array $columns
     * @return Collection
     */
    public function all($columns = array('*'))
    {
        return $this->model->all($columns);
    }

    /**
     * pluck function
     *
     * @param string $column
     * @param string $key
     * @param string $sortColumn
     * @param string $direction
     * @return Collection
     */
    public function pluck($column, $key = null, $sortColumn = null, $direction = 'asc')
    {
        $key = $key ?: 'id';
        $sortColumn = $sortColumn ?: 'id';

        return $this->model->orderBy($sortColumn, $direction)->pluck($column, $key);
    }

    /**
     * findById function
     *
     * @param int|string $id
     * @param array $columns
     * @return Object | Exception
     */
    public function findById($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * findWhere function
     *
     * @param array $conditions
     * @return Object | Exception
     */
    public function findWhere($conditions)
    {
        return $this->model->where($conditions)->first();
    }

    /**
     * create function
     *
     * @param array $data
     * @return Object | Exception
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * insert function
     *
     * @param array $data
     * @return int
     */
    public function insert($data)
    {
        return $this->model->insert($data);
    }

    /**
     * update function
     *
     * @param array $data
     * @param int|string $id
     * @return int
     */
    public function updateById($data, $id)
    {
        $obj = $this->model->findOrFail($id);
        return $obj->update($data);
    }

    /**
     * update function
     *
     * @param object $obj
     * @param array $data
     * @return int
     */
    public function update($obj, $data)
    {
        return $obj->update($data);
    }

    /**
     * destroy function
     *
     * @param int|string $id
     * @return int
     */
    public function destroy($id)
    {
        $obj = $this->model->findOrFail($id);
        return $obj->delete();
    }

    /**
     * Delete by condition
     *
     * @param array $condition
     *
     * @return void
     */
    public function deleteWhere(array $condition)
    {
        $this->model->where($condition)->delete();
    }

    /**
     * Delete where in condition
     *
     * @param string $column
     * @param array $condition
     *
     * @return void
     */
    public function deleteWhereIn(string $column, array $condition)
    {
        $this->model->whereIn($column, $condition)->delete();
    }

    /**
     * force destroy function
     *
     * @param int|string $id
     * @return int
     */
    public function forceDestroy($id)
    {
        $obj = $this->model->findOrFail($id);
        return $obj->forceDelete();
    }

    /**
     * force delete by condition
     *
     * @param array $condition
     *
     * @return void
     */
    public function forceDeleteWhere(array $condition)
    {
        $this->model->where($condition)->forceDelete();
    }

    /**
     * force delete where in condition
     *
     * @param string $column
     * @param array $condition
     *
     * @return void
     */
    public function forceDeleteWhereIn(string $column, array $condition)
    {
        $this->model->whereIn($column, $condition)->forceDelete();
    }

    /**
     * IncrementWhere column
     *
     * @param array $condition
     * @param string $column
     * @param int $value
     *
     * @return void
     */
    public function incrementWhere(array $condition, string $column, int $value)
    {
        $this->model->where($condition)->increment($column, $value);
    }

    /**
     * DecrementWhere column
     *
     * @param array $condition
     * @param string $column
     * @param int $value
     *
     * @return void
     */
    public function decrementWhere(array $condition, string $column, int $value)
    {
        $this->model->where($condition)->decrement($column, $value);
    }

    /**
     * lists function
     *
     * @param string $column
     * @param string $key
     * @return void
     */
    public function lists($column, $key = null)
    {
        return $this->model->lists($column, $key);
    }

    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'findBy')) {
            return $this->dynamicFind($method, $parameters);
        }

        if (Str::startsWith($method, 'getBy')) {
            return $this->dynamicGet($method, $parameters);
        }

        $className = static::class;
        throw new \BadMethodCallException("Call to undefined method {$className}::{$method}()");
    }

    private function dynamicFind($method, $parameters)
    {
        $finder = substr($method, 6);
        $segments = preg_split('/(And|Or)(?=[A-Z])/', $finder, -1);
        $conditionParams = array_splice($parameters, 0, count($segments));
        $query = call_user_func_array([$this->model, 'where' . $finder], $conditionParams);

        return $query->first();
    }

    private function dynamicGet($method, $parameters)
    {
        $finder = substr($method, 5);
        $segments = preg_split('/(And|Or)(?=[A-Z])/', $finder, -1);
        $conditionCount = count($segments);
        $conditionParams = array_splice($parameters, 0, $conditionCount);
        $query = call_user_func_array([$this->model, 'where' . $finder], $conditionParams);

        if (!empty($parameters)) {
            $parameters = $parameters[0];

            if (isset($parameters['order'])) {
                if (is_array($parameters['order'])) {
                    foreach ($parameters['order'] as $key => $order) {
                        $query->orderBy($key, $order);
                    }
                }
            }

            if (isset($parameters['limit'])) {
                $query->limit($parameters['limit']);
            }

            if (isset($parameters['offset'])) {
                $query->offset($parameters['offset']);
            }

            if (isset($parameters['select'])) {
                $query->select($parameters['select']);
            }
        }

        return $query->get();
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * Update or create function
     *
     * @param array $uniqueData
     * @param array $normalData
     * @return Object | Exception
     */
    public function updateOrCreate(array $uniqueData, array $normalData)
    {
        return $this->model->updateOrCreate($uniqueData, $normalData);
    }

    /**
     * First or create function
     *
     * @param array $uniqueData
     * @param array $normalData
     * @return Object
     */
    public function firstOrCreate(array $uniqueData, array $normalData)
    {
        return $this->model->firstOrCreate($uniqueData, $normalData);
    }

    /**
     * Update by condition
     *
     * @param array $condition
     * @param array $data
     * @return int
     */
    public function updateWhere(array $condition, array $data)
    {
        return $this->model->where($condition)->update($data);
    }

    /**
     * Update where in by condition
     *
     * @param string $column
     * @param array $condition
     * @param array $data
     * @return int
     */
    public function updateWhereIn(string $column, array $condition, array $data)
    {
        return $this->model->whereIn($column, $condition)->update($data);
    }

    /**
     * Get where in data
     *
     * @param string $column
     * @param array $data
     *
     * @return Collection
     */
    public function getWhereIn(string $column, array $data)
    {
        return $this->model->whereIn($column, $data)->get();
    }
}