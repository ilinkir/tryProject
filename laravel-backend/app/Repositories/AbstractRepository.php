<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    protected function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return Collection
     */
    protected function getCollection(): Collection
    {
        return $this->getModel()->newCollection();
    }
}
