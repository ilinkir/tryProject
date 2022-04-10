<?php

namespace App\Repositories\User;

use App\Models\UserCars;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class UserCarsRepository extends AbstractRepository
{
    public function __construct(UserCars $model)
    {
        parent::__construct($model);
    }

    public function findByUserId(string $userId): \Illuminate\Support\Collection
    {
        return $this->getModel()->newQuery()
            ->where('user_id', $userId)
            ->pluck('car_id');
    }
}
