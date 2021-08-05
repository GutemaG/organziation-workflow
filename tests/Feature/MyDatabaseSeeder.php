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
        User::factory(20)->create();

        Building::factory(10)->create();

        Bureau::factory(20)->create();

        OnlineRequest::factory(20);


        OnlineRequest::factory(20)
            ->has(PrerequisiteLabel::factory()->count(rand(1,5)))
            ->has(OnlineRequestProcedure::factory()
                ->hasAttached(User::inRandomOrder()->limit(rand(1,5))->get())
                ->count(rand(3,6)))
            ->create();
    }
}
