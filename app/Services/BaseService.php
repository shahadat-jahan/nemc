<?php

namespace App\Services;

use phpDocumentor\Reflection\Types\Boolean;

class BaseService
{
    /**
     * @var model
     */
    protected $model;

    /**
     * Get list
     *
     * @return dataObject
     */
    public function getData()
    {
        return $this->model->get();
    }

    /**
     * @param $request
     * @return insert_id
     */
    public function create($request)
    {
        return $this->model->create($request);
    }

    /**
     * Get single data object
     *
     * @param int $id
     * @return dataObject
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Update data
     *
     * @param $request
     * @param int $id
     * @return boolean
     */
    public function update($request, $id)
    {
        return $this->model->find($id)->update($request);
    }

    /**
     * Delete data
     *
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * get list
     *
     * @return array
     */
    public function lists()
    {
        return $this->model->orderBy('title', 'asc')->pluck('title', 'id');
    }

    public function listByStatus()
    {
        return $this->model->where('status', 1)->orderBy('title', 'asc')->pluck('title', 'id');
    }

    public function findBy($conditions, $first = null)
    {
        $query = $this->model->where(function ($q) use($conditions){
            foreach ($conditions as $key => $value){
                if (is_array($value)) {
                    $q->whereIn($key, $value);
                } else {
                    $q->where($key, $value);
                }
            }
        });

        if ( empty($first)){
            return $query->first();
        }

        return $query->get();

    }

    public function findWith($id, array $with)
    {
        return $this->model->with($with)->find($id);
    }

    public function whereIn($column, array $value)
    {
        return $this->model->whereIn($column, $value);
    }

}
