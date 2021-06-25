<?php

namespace Database\Seeders;
use App\Models\Building;
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
         User::factory()->create([

            'user_name' => 'admin',
            'first_name' =>'birhanu',
            'last_name' => 'Gudisa',
            'email' => 'owgs@astu.com',
            'type' => 'admin',
            'password' => Hash::make('laravel1234'), // password
            'remember_token' => Str::random(10),
         ]
         );
         User::factory(500)->create();

         Building::factory(100)->create();
    }
}
