<?php

namespace App\News\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class NewsRepository extends AbstractRepository
{
    public function __construct(News $model)
    {
        parent::__construct($model);
    }

    public function getAll(): ?Collection
    {
        return $this->getModel()->query()
            ->select(
                'id',
                'title',
                'code',
                'preview_text',
                'text',
                'category_id',
                'image_id',
                'is_active',
                'sort',
                'created_at',
                'updated_at',
            )
            ->where('is_active', '=', true)
            ->get();
    }

    public function getByCode(string $code): ?Model
    {
        return $this->getModel()
            ->select(
                'id',
                'name',
                'code',
                'description',
                'created_at',
                'is_active',
                'category_id',
            )
            ->where('code', $code)
            ->where('is_active', true)
            ->first();
    }

    public function paginate(int $limit): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->getModel()->query()
            ->paginate($limit);
    }

    public function simplePaginate(int $limit): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getModel()->query()
            ->simplePaginate($limit);
    }

    public function bindCategory($products)
    {
        return empty($products) ? $products : $products->load('category');
    }

}
