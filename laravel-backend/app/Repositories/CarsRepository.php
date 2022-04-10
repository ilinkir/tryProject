<?php

namespace App\Repositories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CarsRepository extends AbstractRepository
{
    public function __construct(Car $model)
    {
        parent::__construct($model);
    }

    private function allColumns(): array
    {
        return [
            'id',
            'complectation_name',
            'model_name',
            'model_year',
            'created_at',
            'updated_at'
        ];
    }

    public function getById(string|array $id): Collection
    {
        return $this->getModel()->newQuery()
            ->select($this->allColumns())
            ->find($id);
    }
}
