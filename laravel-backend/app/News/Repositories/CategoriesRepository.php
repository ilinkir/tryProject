<?php

namespace App\News\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoriesRepository extends AbstractRepository
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAll(): ?Collection
    {
        return $this->getModel()->query()
            ->select(
                'id',
                'name',
                'code',
                'description',
                'created_at',
                'updated_at',
            )
            ->where('is_active', '=', true)
            ->get();
    }
}
