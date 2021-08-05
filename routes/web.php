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

});

// public routes
Route::prefix('api')->group(function (){
    Route::get('/online-requests', [OnlineRequestController::class, 'index']);
    Route::get('/online-requests/{online_request}', [OnlineRequestController::class, 'show']);
});

Route::get('/test', function () {
     \App\Models\OnlineRequestTracker::factory()->count(1)
        ->create()->each(function ($request) {
            $procedures = $request->onlineRequest->onlineRequestProcedures;
            $old = null;
            foreach ($procedures as $procedure) {
                $temp = \App\Models\OnlineRequestStep::create([
                    'online_request_tracker_id' => $request->id,
                    'online_request_procedure_id' => $procedure->id,
                    'user_id' => $procedure->users->first()->id,
                    'is_completed' => random_int(0, 1),
                    'started_at' => now(),
                ]);
                if ($old)
                    $old->update(['next_step' => $temp->id]);
                $old = $temp;
            }
            dump(\App\Models\OnlineRequestTracker::with(['onlineRequestSteps'])
                ->where('id', $request->id)->get()->first()->toArray());
        });
});




//Route::middleware(['auth'])->prefix('api')->group(function (){
//Route::get('/home', function () {
//    return view('home');
//})->middleware('verified')->name('home');



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/test/', function () {
////    \App\Models\OnlineRequest::factory(20)->hasPrerequisiteLabels(rand(3,6))->create();
//});
    // Route::resource('/affairs', \App\Http\Controllers\AffairController::class);
//    Route::delete('/delete-procedure/{id}/{affair_id}', [\App\Http\Controllers\AffairController::class, 'deleteProcedure']);
//    Route::delete('/delete-pre-request/{id}/{procedure_id}', [\App\Http\Controllers\AffairController::class, 'deletePreRequest']);
//    Route::post('/add-procedure', [\App\Http\Controllers\AffairController::class, 'addProcedure']);
//    Route::post('/add-pre-request', [\App\Http\Controllers\AffairController::class, 'addPreRequest']);

//    Route::resource('/online-requests', \App\Http\Controllers\OnlineRequestController::class);
//    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
//});

//Route::resource('/api/affairs', \App\Http\Controllers\AffairController::class);
//Route::get('/test/', function () {
//    //    \App\Models\OnlineRequest::factory(20)->hasPrerequisiteLabels(rand(3,6))->create();
//});
// Route::get('/affairs', '\App\Http\Controllers\AffairController@index');
// Route::post('/affairs', '\App\Http\Controllers\AffairController@store');

Route::get('/{vue_capture?}', function () {
    return view('home');
})->where('vue_capture', '[\/\w\.-]*');

