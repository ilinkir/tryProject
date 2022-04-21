<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test', [\App\Http\Controllers\TestController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function () {
    return \Illuminate\Support\Facades\Auth::user();
});

Route::prefix('sanctum')->group(function() {
    Route::controller(\App\Http\Controllers\Users\AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/token', 'token');
    });
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/cars', [\App\Http\Controllers\Users\CarsController::class, 'getOwnCars']);
});

//Route::prefix('users')->group(function () {
//    Route::post('/register', [\App\Http\Controllers\Users\RegistrationController::class, 'register']);
//    Route::get('/verify/{token}', [\App\Http\Controllers\Users\RegistrationController::class, 'verify'])->where('token', '.*')->name('register.verify');
//});

Route::prefix('news')->group(function () {
    Route::controller(\App\Http\Controllers\News\NewsController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/filter', 'filter');
        Route::get('/{code}', 'detail');
    });
});

Route::get('broadcast', function () {
    broadcast(new App\Events\TestEvent('Hello!!!!'));
});

Route::middleware('auth:sanctum')->post('import', [\App\Http\Controllers\Csv\ImportController::class, 'importProcess']);
