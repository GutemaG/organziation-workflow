<?php

use App\Exceptions\MissingModelException;
use App\Http\Controllers\NotificationTrackerController;
use App\Http\Controllers\OnlineRequestTrackerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// private routes
Route::middleware(['auth'])->prefix('api')->group(function() {
    Route::get('/online-request-applied/accept/{notification_tracker}', [NotificationTrackerController::class, 'onlineRequestAccept'])
        ->missing(function (Request $request) {
            throw new MissingModelException();
        });

    Route::get('/online-request-applied/complete/{notification_tracker}', [NotificationTrackerController::class, 'onlineRequestComplete'])
        ->missing(function (Request $request) {
            throw new MissingModelException();
        });

    Route::put('/online-request-applied/reject/{notification_tracker}', [NotificationTrackerController::class, 'onlineRequestReject'])
        ->missing(function (Request $request) {
            throw new MissingModelException();
        });

    Route::get('/online-request-applied', [NotificationTrackerController::class, 'index']);
});

// public routes
Route::prefix('api')->group(function () {
    Route::get('/apply-request/{online_request_tracker:token}', [OnlineRequestTrackerController::class, 'appliedRequest']);
    Route::post('/apply-request', [OnlineRequestTrackerController::class, 'applyRequest']);
});
