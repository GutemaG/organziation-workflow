<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Bureau;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\PrerequisiteLabel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait MyDatabaseSeeder
{
    public static  function seed() {
        User::create([
                'user_name' => 'Admin',
                'first_name' =>'birhanu',
                'last_name' => 'Gudisa',
                'email' => 'owgs@astu.com',
                'type' => 'admin',
                'password' => Hash::make('laravel1234'), // password
                'remember_token' => Str::random(10),
            ]
        );
        User::factory(30)->create();

        Building::factory(5)->create();

        Bureau::factory(5)->create();

        OnlineRequest::factory(5)->create()->each(function ($onlineRequest) {
            PrerequisiteLabel::factory(rand(1, 3))->create(['online_request_id' => $onlineRequest->id]);
            $length = rand(2, 5);
            for ($i = 1; $i < $length; $i++) {
                OnlineRequestProcedure::factory(1)
                    ->create(['online_request_id' => $onlineRequest->id, 'step_number' => $i])
                    ->each(function ($onlineRequestProcedure) {
                        $onlineRequestProcedure->users()
                            ->attach(User::select('id')->Where('type', 'staff')->inRandomOrder()->limit(random_int(1,3))->get());
                    });
            }

        });
//            ->has(PrerequisiteLabel::factory()->count(rand(1,5)))
//            ->has(OnlineRequestProcedure::factory()->count(rand(3,6))
//                ->each(function ($onlineRequestProcedure) {
////                    $onlineRequestProcedure
////                        ->attach(User::select('id')->inRandomOrder()->limit(rand(1,5))->get());
//                }))
//            ->create();
//        for ($i=0;$i<20;$i++){
//        $isDone = random_int(0,1) == 0;
//        $ended_at = now()->addDay();
//        \App\Models\OnlineRequestTracker::factory()->count(1)
//            ->create(['started_at' => now(), 'ended_at' => $isDone ? $ended_at : null])
//            ->each(function ($request) use ($isDone) {
//                $procedures = $request->onlineRequest->onlineRequestProcedures;
//                $old = null;
//                $time = now();
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
//        }
    }
}
