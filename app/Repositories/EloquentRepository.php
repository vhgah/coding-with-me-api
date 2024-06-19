<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class EloquentRepository
{
    abstract protected function query(array $options = []): Builder;

    public function find($id)
    {
        return $this->query()->whereKey($id)->first();
    }

    public function paginate($args = [], $perPage = 15, $columns = ['*'], $pageParam = 'page')
    {
        return $this->query($args)->paginate($perPage, $columns, $pageParam);
    }
}
