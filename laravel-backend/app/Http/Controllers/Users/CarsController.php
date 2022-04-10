<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Repositories\CarsRepository;
use App\Repositories\User\UserCarsRepository;
use Illuminate\Support\Facades\Auth;

class CarsController extends Controller
{
    public function getOwnCars(UserCarsRepository $userCarsRepository, CarsRepository $carsRepository)
    {
        $userId = Auth::id();

        $carsIds = $userCarsRepository->findByUserId($userId)->values()->toArray();
        $cars = $carsRepository->getById($carsIds);

        return response()->json($cars);
    }
}
