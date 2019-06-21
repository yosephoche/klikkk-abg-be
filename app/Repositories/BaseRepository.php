<?php

namespace App\Repositories;

abstract class BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    abstract public function model();

    public function get()
    {
        return $this->model->get();
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        if ($model = $this->find($id)) {
            return $model->update($attributes) !== false;
        } else {
            return false;
        }

    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete($id, $force = false)
    {
        if ($model = $this->find($id)) {
            if ($force) {
                return $model->forceDelete();
            }
            return $model->delete();
        } else {
            return false;
        }
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->model = $this->model->where($column, $operator, $value, $boolean);
        return $this;
    }

    public function take($number)
    {

        $this->model = $this->model->limit($number);
        return $this;
    }

    public function whereNotNull($param)
    {
        $this->model = $this->model->whereNotNull($param);
        return $this;
    }

    public function whereMonth($column,$operator,$value = null,$boolean = 'and')
    {
        $this->model = $this->model->whereMonth($column, $operator, $value, $boolean);
        return $this;
    }

    public function whereYear($column,$operator,$value = null,$boolean = 'and')
    {
        $this->model = $this->model->whereYear($column, $operator, $value, $boolean);
        return $this;
    }

    public function restore()
    {
        $this->model = $this->model->restore();
        return $this;
    }

    public function count()
    {
        return $this->model->count();
    }
}
