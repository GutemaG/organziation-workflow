<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return view('layouts.master');
});

//Route::get('/home', function () {
//    return view('home');
//})->middleware('verified')->name('home');
require __DIR__ . '/auth.php';



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::resource('/users', \App\Http\Controllers\UserController::class);

    Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update'])
        ->name('account.update');

    Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword'])
        ->name('account.change.password');

    Route::resource('/buildings', \App\Http\Controllers\BuildingController::class);

    Route::resource('/bureaus', \App\Http\Controllers\BureauController::class);
    // Route::resource('/affairs', \App\Http\Controllers\AffairController::class);
    Route::delete('/delete-procedure/{id}/{affair_id}', [\App\Http\Controllers\AffairController::class, 'deleteProcedure']);
    Route::delete('/delete-pre-request/{id}/{procedure_id}', [\App\Http\Controllers\AffairController::class, 'deletePreRequest']);
    Route::post('/add-procedure', [\App\Http\Controllers\AffairController::class, 'addProcedure']);
    Route::post('/add-pre-request', [\App\Http\Controllers\AffairController::class, 'addPreRequest']);

    Route::resource('/online-requests', \App\Http\Controllers\OnlineRequestController::class);
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::resource('/api/affairs', \App\Http\Controllers\AffairController::class);
Route::get('/test/', function () {
    //    \App\Models\OnlineRequest::factory(20)->hasPrerequisiteLabels(rand(3,6))->create();
});
// Route::get('/affairs', '\App\Http\Controllers\AffairController@index');
// Route::post('/affairs', '\App\Http\Controllers\AffairController@store');

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
