<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\User\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function index(UsersRepository $usersRepository)
    {
        dd($usersRepository->findAllForNotificationNews());
    }
}
