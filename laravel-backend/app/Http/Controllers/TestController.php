<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function index()
    {
//        User::create([
//            'name' => 'test',
//            'password' => '123',
//            'email' => 'test@test.ru',
//        ]);

        $user = User::query()->where('name', 'test')->get();
        dd($user);
    }
}
