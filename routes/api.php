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
//Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update']);
//Route::resource('buildings', \App\Http\Controllers\BuildingController::class);
//Route::resource('bureaus', \App\Http\Controllers\BureauController::class);
//Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword']);
Route::resource('/online-requestss', \App\Http\Controllers\OnlineRequestController::class);

Route::resource('/users', \App\Http\Controllers\UserController::class);

Route::resource('/affairss', \App\Http\Controllers\AffairController::class);
// Route::resource('/users', \App\Http\Controllers\UserController::class); 
// Route::resource('/users', \App\Http\Controllers\UserController::class);
// Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update']);
// Route::resource('buildings', \App\Http\Controllers\BuildingController::class);
// Route::resource('bureaus', \App\Http\Controllers\BureauController::class);
// Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword']);

// Route::resource('/users', \App\Http\Controllers\UserController::class);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/*
Route::delete('/delete-procedure/{id}/{affair_id}',function($id, $affair_id){
    return response()->json([
        'id'=>$id,
        'affair_id'=>$affair_id
    ]);
});
*/