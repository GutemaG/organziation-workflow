<?php

use App\Exceptions\MissingModelException;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OnlineRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('layouts.master');
});

require __DIR__.'/auth.php';

// private routes
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::resource('/users', \App\Http\Controllers\UserController::class);

    Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update'])
        ->name('account.update');

    Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword'])
        ->name('account.change.password');

    Route::resource('/buildings', \App\Http\Controllers\BuildingController::class);

    Route::resource('/bureaus', \App\Http\Controllers\BureauController::class);

    Route::apiResource('/online-requests', OnlineRequestController::class)
        ->only(['store', 'update', 'destroy'])
        ->missing(function (Request $request) {
            throw new  MissingModelException();
        });

    Route::put('/online-prerequisites/{prerequisite_label}', [\App\Http\Controllers\OnlinePrerequisiteController::class, 'update']);

    Route::delete('/online-prerequisites/{prerequisite_label}', [\App\Http\Controllers\OnlinePrerequisiteController::class, 'destroy']);

    Route::put('/online-procedures/{procedure}', [\App\Http\Controllers\OnlineRequestProcedureController::class, 'update']);

    Route::delete('/online-procedures/{procedure}', [\App\Http\Controllers\OnlineRequestProcedureController::class, 'destroy']);

    //Birhanu
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::apiResource('/api/affairs', \App\Http\Controllers\AffairController::class)
        ->only(['store', 'update', 'destroy']);

    Route::delete('/delete-procedure/{id}/{affair_id}', [\App\Http\Controllers\AffairController::class, 'deleteProcedure']);
    Route::delete('/delete-pre-request/{id}/{procedure_id}', [\App\Http\Controllers\AffairController::class, 'deletePreRequest']);
    Route::post('/add-procedure', [\App\Http\Controllers\AffairController::class, 'addProcedure']);
    Route::post('/add-pre-request', [\App\Http\Controllers\AffairController::class, 'addPreRequest']);


});

// public routes
Route::prefix('api')->group(function (){
    Route::get('/online-requests', [OnlineRequestController::class, 'index']);
    Route::get('/online-requests/{online_request}', [OnlineRequestController::class, 'show']);

    //Birhanu
    Route::get('/affairs', '\App\Http\Controllers\AffairController@index');
});

Route::get('/{vue_capture?}', function () {
    return view('layouts.master');
})->where('vue_capture', '[\/\w\.-]*');