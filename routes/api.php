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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', App\Http\Controllers\Api\UserController::class)
    ->only('update', 'store', 'index', 'show');

Route::apiResource('files', App\Http\Controllers\Api\FileController::class)
    ->only('store', 'destroy', 'index', 'show');

Route::apiResource('tags', App\Http\Controllers\Api\TagController::class)
    ->only('update', 'store', 'destroy', 'index', 'show');

Route::apiResource('posts', App\Http\Controllers\Api\PostController::class)
    ->only('update', 'store', 'destroy', 'index', 'show');
