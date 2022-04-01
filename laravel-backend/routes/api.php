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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Users\RegistrationController::class, 'register']);
    Route::get('/verify/{token}', [\App\Http\Controllers\Users\RegistrationController::class, 'verify'])->where('token', '.*')->name('register.verify');
});

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
