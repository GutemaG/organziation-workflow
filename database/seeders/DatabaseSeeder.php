<?php

namespace Database\Seeders;
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
         \App\Models\User::factory()->create([
         
            'user_name' => 'admin',
            'first_name' =>'birhanu',
            'last_name' => 'Gudisa',
            'email' => 'owgs@astu.com',
            'is_active' => true,
            'is_admin' => true,
            'email_verified_at' => now(),
            'password' => Hash::make('laravel1234'), // password
            'remember_token' => Str::random(10),
         ]
         );
         \App\Models\User::factory(30)->create();
    }
}
