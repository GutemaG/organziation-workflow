<?php

use App\Exceptions\MissingModelException;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\FrequentlyViewedRequestController;

Route::prefix('api')->group(function() {
    Route::get('/online-requests/increment/{online_request}', [FrequentlyViewedRequestController::class, 'incrementOnlineRequest'])
        ->missing(function (Request $request) {
            throw new MissingModelException();
        });

    Route::get('/online-requests/most-viewed/{limit?}', [FrequentlyViewedRequestController::class, 'frequentlyViewedOnlineRequest']);

    Route::get('/affairs/increment/{affair}', [FrequentlyViewedRequestController::class, 'incrementAffair'])
        ->missing(function (Request $request) {
            throw new MissingModelException();
        });

    Route::get('/affairs/most-viewed/{limit?}', [FrequentlyViewedRequestController::class, 'frequentlyViewedAffair']);
});
