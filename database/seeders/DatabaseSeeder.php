<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Bureau;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\PrerequisiteLabel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    /*    
          User::create([
            'user_name' => 'Staff',
            'first_name' =>'Israel',
            'last_name' => 'Hawaria',
            'email' => 'staff@astu.com',
            'type' => 'staff',
            'password' => Hash::make('laravel1234'), // password
            'remember_token' => Str::random(10),
         ]
         );
         User::create([
            'user_name' => 'kal',
            'first_name' =>'Kaleab',
            'last_name' => 'Alabachew',
            'email' => 'reception@astu.com',
            'type' => 'reception',
            'password' => Hash::make('laravel1234'), // password
            'remember_token' => Str::random(10),
         ]
         );
         
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
         \App\Models\User::factory(50)->create();
         
         \App\Models\Affair::factory(50)->create();
         

         User::create([
            'user_name' => 'supportiveTeam',
            'first_name' =>'Henok',
            'last_name' => 'Kebed',
            'email' => 'supportiveTeam@astu.com',
            'type' => 'it_team_member',
            'password' => Hash::make('laravel1234'), // password
            'remember_token' => Str::random(10),
         ]
         );
         */
         return;
         Building::factory(100)->create();

         Bureau::factory(200)->create();
         \App\Models\Procedure::factory(100)->create();
         \App\Models\PreRequest::factory(200)->create();

        \App\Models\PreRequest::factory()->create([
            'affair_id'=>null,
            'procedure_id'=>1,
            'name' =>'go somewhere',
            'description' =>' Description go somewhere'
        ]);
        



        OnlineRequest::factory(20);
        


        //        OnlineRequest::factory(20)
        //            ->has(\App\Models\PrerequisiteLabel::factory()->count(rand(1,5)))
        //            ->has(\App\Models\OnlineRequestProcedure::factory()
        //                ->hasAttached(\App\Models\User::inRandomOrder()->limit(rand(1,5))->get())
        //                ->count(rand(3,6)))
        //            ->create();

        OnlineRequest::factory()->count(20)->create()->each(function ($request) {
            $stepNumber = 1;
            $length = random_int(3, 6);
            PrerequisiteLabel::factory()->count(random_int(1, 5))->create(['online_request_id' => $request->id]);

            for ($i = 0; $i < $length; $i++) {
                OnlineRequestProcedure::factory()
                    ->hasAttached(\App\Models\User::inRandomOrder()->limit(rand(1, 5))->get())
                    ->count(1)
                    ->create(['step_number' => $stepNumber++, 'online_request_id' => $request->id]);
            }
        });
        
       
    }
}
