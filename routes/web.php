<?php

use App\Exceptions\MissingModelException;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\OnlineRequestController;
use App\Http\Controllers\OnlineRequestTrackerController;
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

    Route::get('/online-request-steps', [\App\Http\Controllers\OnlineRequestStepController::class, 'index']);

    //Birhanu
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::apiResource('/affairs', \App\Http\Controllers\AffairController::class)
        ->only(['store', 'update', 'destroy']);

    Route::delete('/delete-procedure/{id}/{affair_id}', [\App\Http\Controllers\AffairController::class, 'deleteProcedure']);
    Route::delete('/delete-pre-request/{id}/{procedure_id}', [\App\Http\Controllers\AffairController::class, 'deletePreRequest']);
    Route::post('/add-procedure', [\App\Http\Controllers\AffairController::class, 'addProcedure']);
    Route::post('/add-pre-request', [\App\Http\Controllers\AffairController::class, 'addPreRequest']);


});

// public routes
Route::prefix('api')->group(function (){
    Route::get('/online-requests', [OnlineRequestController::class, 'index']);
    Route::get('/online-requests/{online_request}', [OnlineRequestController::class, 'show'])
        ->missing(function (Request $request) {
            throw new  MissingModelException();
        });
    Route::get('/apply-request/{online_request_tracker:token}', [OnlineRequestTrackerController::class, 'appliedRequest']);
    Route::post('/apply-request', [OnlineRequestTrackerController::class, 'applyRequest']);

    //Birhanu
    Route::get('/affairs', '\App\Http\Controllers\AffairController@index');
});


// for test
Route::get('/test', function () {
    \App\Events\OnlineRequestEvent::dispatch('this is test');
    return true;

//    for ($i=0;$i<20;$i++){
//        $isDone = random_int(0,1) == 0;
//        $ended_at = now()->addDay();
//        \App\Models\OnlineRequestTracker::factory()->count(1)
//            ->create(['started_at' => now(), 'ended_at' => $isDone ? $ended_at : null])
//            ->each(function ($request) use ($isDone) {
//                $procedures = $request->onlineRequest->onlineRequestProcedures;
//                $old = null;
//                $time = now();
////                $isComplete = $isDone;
////
////                function complete() use (&$isComplete, $isDone): bool
////                {
////                    if ($isDone)
////                        return true;
////                    elseif ($isComplete) {
////                        $complete = random_int(0,1) == 1;
////                        $isComplete = $complete;
////                        return $complete;
////                    }
////                    return false;
////                }
//
//                foreach ($procedures as $procedure) {
//                    $done = null;
//                    if ($isDone)
//                        $done = true;
//                    else{
//                        if (random_int(0,1) == 0)
//                            $done = false;
//                        else
//                            $done = true;
//                    }
//                    $time = now()->addHour();
//                    $temp = \App\Models\OnlineRequestStep::create([
//                        'online_request_tracker_id' => $request->id,
//                        'online_request_procedure_id' => $procedure->id,
//                        'user_id' => $procedure->users->first()->id,
//                        'started_at' => $time,
//                        'ended_at' => $done ? $time : null,
//                        'is_completed' => $done,
//                        'is_rejected' => !$done,
//                        'reason' => $done ? null : \Illuminate\Support\Str::random(random_int(30, 50))
//                    ]);
//                    if ($old)
//                        $old->update(['next_step' => $temp->id]);
//                    $old = $temp;
//                }
//            });
//
//    }

//    \App\Models\OnlineRequestTracker::factory()->count(20)
//        ->create()->each(function ($request) {
//            $procedures = $request->onlineRequest->onlineRequestProcedures;
//            $old = null;
//            foreach ($procedures as $procedure) {
//                $temp = \App\Models\OnlineRequestStep::create([
//                    'online_request_tracker_id' => $request->id,
//                    'online_request_procedure_id' => $procedure->id,
//                    'user_id' => $procedure->users->first()->id,
//                    'is_completed' => random_int(0, 1),
//                    'started_at' => now(),
//                ]);
//                if ($old)
//                    $old->update(['next_step' => $temp->id]);
//                $old = $temp;
//            }
//            dump(\App\Models\OnlineRequestTracker::with(['onlineRequestSteps'])
//                ->where('id', $request->id)->get()->first()->toArray());
//        });
    });



    Route::get('/{vue_capture?}', function () {
        return view('layouts.master');
    })->where('vue_capture', '[\/\w\.-]*');


//Route::get('/', function () {
//    return view('layouts.master');
//});
//
//require __DIR__.'/auth.php';
//
//// private routes
//Route::middleware(['auth'])->prefix('api')->group(function () {
//    Route::resource('/users', \App\Http\Controllers\UserController::class);
//
//    Route::post('/account', [\App\Http\Controllers\AccountController::class, 'update'])
//        ->name('account.update');
//
//    Route::post('/account/change-password', [\App\Http\Controllers\AccountController::class, 'changePassword'])
//        ->name('account.change.password');
//
//    Route::resource('/buildings', \App\Http\Controllers\BuildingController::class);
//
//    Route::resource('/bureaus', \App\Http\Controllers\BureauController::class);
//
//    Route::apiResource('/online-requests', OnlineRequestController::class)
//        ->only(['store', 'update', 'destroy'])
//        ->missing(function (Request $request) {
//            throw new  MissingModelException();
//        });
//
//    Route::put('/online-prerequisites/{prerequisite_label}', [\App\Http\Controllers\OnlinePrerequisiteController::class, 'update']);
//
//    Route::delete('/online-prerequisites/{prerequisite_label}', [\App\Http\Controllers\OnlinePrerequisiteController::class, 'destroy']);
//
//    Route::put('/online-procedures/{procedure}', [\App\Http\Controllers\OnlineRequestProcedureController::class, 'update']);
//
//    Route::delete('/online-procedures/{procedure}', [\App\Http\Controllers\OnlineRequestProcedureController::class, 'destroy']);
//
//
//// public routes
//Route::prefix('api')->group(function (){
//    Route::get('/online-requests', [OnlineRequestController::class, 'index']);
//    Route::get('/online-requests/{online_request}', [OnlineRequestController::class, 'show']);
//});
//

//});
//
//
//
//
////Route::middleware(['auth'])->prefix('api')->group(function (){
////Route::get('/home', function () {
////    return view('home');
////})->middleware('verified')->name('home');
//
//
//
//// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
////Route::get('/test/', function () {
//////    \App\Models\OnlineRequest::factory(20)->hasPrerequisiteLabels(rand(3,6))->create();
////});
//    // Route::resource('/affairs', \App\Http\Controllers\AffairController::class);
////    Route::delete('/delete-procedure/{id}/{affair_id}', [\App\Http\Controllers\AffairController::class, 'deleteProcedure']);
////    Route::delete('/delete-pre-request/{id}/{procedure_id}', [\App\Http\Controllers\AffairController::class, 'deletePreRequest']);
////    Route::post('/add-procedure', [\App\Http\Controllers\AffairController::class, 'addProcedure']);
////    Route::post('/add-pre-request', [\App\Http\Controllers\AffairController::class, 'addPreRequest']);
//
////    Route::resource('/online-requests', \App\Http\Controllers\OnlineRequestController::class);
////    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
////});
//
////Route::resource('/api/affairs', \App\Http\Controllers\AffairController::class);
////Route::get('/test/', function () {
////    //    \App\Models\OnlineRequest::factory(20)->hasPrerequisiteLabels(rand(3,6))->create();
////});
//// Route::get('/affairs', '\App\Http\Controllers\AffairController@index');
//// Route::post('/affairs', '\App\Http\Controllers\AffairController@store');
//
//Route::get('/{vue_capture?}', function () {
//    return view('home');
//})->where('vue_capture', '[\/\w\.-]*');

