<?php

use App\Exceptions\MissingModelException;
use App\Http\Controllers\FrequentlyAskedQuestionController;
use Illuminate\Support\Facades\Route;
    use Illuminate\Http\Request;

    // Public routes
    Route::prefix('api')->group(function () {
        Route::get('/faqs', [FrequentlyAskedQuestionController::class, 'index'])
            ->missing(function (Request $request) {
                throw new MissingModelException();
            });

        Route::get('/faqs/{frequently_asked_question}', [FrequentlyAskedQuestionController::class, 'show'])
            ->missing(function (Request $request) {
                throw new MissingModelException();
            });
    });

    // Private routes authorized only for staff authenticated user only.
    Route::middleware(['auth', 'is.reception'])->prefix('api')->group(function () {
        Route::delete('/faqs/{frequently_asked_question}', [FrequentlyAskedQuestionController::class, 'destroy'])
            ->missing(function (Request $request) {
                throw new MissingModelException();
            });

        Route::post('/faqs', [FrequentlyAskedQuestionController::class, 'store']);

        Route::put('/faqs/{frequently_asked_question}', [FrequentlyAskedQuestionController::class, 'update'])
            ->missing(function (Request $request) {
                throw new MissingModelException();
            });
    });
