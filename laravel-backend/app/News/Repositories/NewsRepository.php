<?php

namespace App\News\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getById(string $id): ?Model
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
            ->where('id', $id)
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

    public function create(array $properties): Model
    {
        DB::beginTransaction();

        $model = $this->getModel();

        $model->fill($properties);
        $model->save();

        if (!empty($properties['category'])) {
            $model->category()->sync($properties['category']);
        }

        DB::commit();

        return $model;
    }

    public function update(string $id, array $properties): bool
    {
        DB::beginTransaction();

        $model = $this->getById($id);

        if ($model && $success = $model->update($properties)) {
            if (array_key_exists('category', $properties)) {
                $model->category->detach();
                if (!empty($properties['category'])) {
                    $model->category()->sync($properties['category']);
                }
            }
        }

        DB::commit();

        return $success ?? false;
    }

}
