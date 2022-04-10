<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserCars;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;

class UsersRepository extends AbstractRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->getModel()->newQuery()->select([
            'id',
            'name',
            'email',
        ])->get();
    }

    public function findAllForNotificationNews()
    {
        $users = $this->getAll()->load('settings');

        return $users->filter(function ($user) {
            dump($user->settings?->news_email_notification);
            if(empty($user->settings) || $user->settings?->news_email_notification == true) {
                return $user;
            }
        });
    }
}
