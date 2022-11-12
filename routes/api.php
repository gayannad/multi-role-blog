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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
});


Route::group(['prefix' => 'v1', 'middleware' => 'auth:sanctum'], function () {

    Route::group(['middleware' => 'roles', 'roles' => ['admin', 'manager', 'user']], function () {
        Route::get('posts', [\App\Http\Controllers\PostController::class, 'index']);
        Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store']);
        Route::get('/posts/{post}', [\App\Http\Controllers\PostController::class, 'show']);
        Route::put('/posts/{post}', [\App\Http\Controllers\PostController::class, 'update']);
        Route::delete('/posts/{post}', [\App\Http\Controllers\PostController::class, 'destroy']);
    });

    //only for admin user
    Route::group(['middleware' => 'roles', 'roles' => ['admin']], function () {
        Route::get('users', [\App\Http\Controllers\UserController::class, 'index']);
        Route::post('users', [\App\Http\Controllers\UserController::class, 'store']);
        Route::get('users/{user}', [\App\Http\Controllers\UserController::class, 'show']);
        Route::put('users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
        Route::delete('users/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
    });
});



