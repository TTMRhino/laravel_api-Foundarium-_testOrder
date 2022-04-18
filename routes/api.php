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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/cars', [App\Http\Controllers\Api\V1\CarsApiController::class, 'index']);
Route::get('/cars/{id}', [App\Http\Controllers\Api\V1\CarsApiController::class, 'show']);
Route::get('/user', [App\Http\Controllers\Api\V1\UserApiController::class, 'index']);
Route::get('/user/{id}', [App\Http\Controllers\Api\V1\UserApiController::class, 'show']);
Route::get('/user/{id}/getcar/{carname}', [App\Http\Controllers\Api\V1\UserApiController::class, 'getcar']);


