<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/home', function () {
//    return view('home');
//})->middleware('verified')->name('home');
require __DIR__.'/auth.php';



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->prefix('api')->group(function (){
    Route::resource('/users', \App\Http\Controllers\UserController::class);
});


Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
