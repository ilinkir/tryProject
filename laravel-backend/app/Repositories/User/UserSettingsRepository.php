<?php

namespace App\Repositories\User;

use App\Models\UserCars;
use App\Models\UserSettings;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class UserSettingsRepository extends AbstractRepository
{
    public function __construct(UserSettings $model)
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
