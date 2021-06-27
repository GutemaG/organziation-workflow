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

//Route::resource('/users', \App\Http\Controllers\UserController::class);
//Route::get('/account', [\App\Http\Controllers\AccountController::class, 'update']);
//Route::resource('buildings', \App\Http\Controllers\BuildingController::class);
Route::resource('bureaus', \App\Http\Controllers\BureauController::class);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
