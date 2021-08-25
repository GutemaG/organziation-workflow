<?php

use App\Exceptions\MissingModelException;
use App\Http\Controllers\OnlineRequestController;
use Illuminate\Support\Facades\Route;

// private routes
Route::middleware(['auth', 'is.admin.or.supportive.staff'])->prefix('api')->group(function() {
    Route::apiResource('/online-requests', OnlineRequestController::class)
        ->only(['store', 'update', 'destroy'])
        ->missing(function (Request $request) {
            throw new  MissingModelException();
        });
});

// public routes
Route::prefix('api')->group(function() {
    Route::get('/online-requests', [OnlineRequestController::class, 'index']);
    Route::get('/online-requests/{online_request}', [OnlineRequestController::class, 'show'])
        ->missing(function (Request $request) {
            throw new  MissingModelException();
        });
});
