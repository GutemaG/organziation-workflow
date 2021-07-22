<?php

use App\Exceptions\MissingModelException;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->prefix('api')->group(function (){
    Route::resource('/users', \App\Http\Controllers\UserController::class);

    Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update'])
        ->name('account.update');

    Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword'])
        ->name('account.change.password');

    Route::resource('/buildings', \App\Http\Controllers\BuildingController::class);

    Route::resource('/bureaus', \App\Http\Controllers\BureauController::class);

    Route::resource('/online-requests', \App\Http\Controllers\OnlineRequestController::class)
        ->missing(function (Request $request) {
            throw new  MissingModelException();
        });

});

//Route::get('/test/', function () {
////    \App\Models\OnlineRequest::factory(20)->hasPrerequisiteLabels(rand(3,6))->create();
//});

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');

