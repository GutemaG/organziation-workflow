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

<<<<<<< HEAD
Route::resource('/users', \App\Http\Controllers\UserController::class); 

=======
>>>>>>> 6b7fba761e5fbb5d4ecf29612adc6d396aa487ff
//Route::resource('/users', \App\Http\Controllers\UserController::class);
//Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update']);
//Route::resource('buildings', \App\Http\Controllers\BuildingController::class);
//Route::resource('bureaus', \App\Http\Controllers\BureauController::class);
<<<<<<< HEAD
=======
//Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword']);

Route::resource('/users', \App\Http\Controllers\UserController::class);
>>>>>>> 6b7fba761e5fbb5d4ecf29612adc6d396aa487ff


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
