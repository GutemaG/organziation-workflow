<?php


namespace Tests\Feature\Utilities;


use Database\Factories\Utility;
use Faker\Factory;
use Illuminate\Support\Str;

class FakeDataGenerator
{
    public static function userData(){
        $faker = Factory::create();
        return [
            'user_name' => $faker->unique()->name(),
            'first_name' => $faker->name(),
            'last_name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'phone' => Utility::getPhoneNumber(),
            'type' => Utility::getUserType(),
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
    }

    public static function userDataOnly($fields=[]){
        $data = self::userData();
        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($key, $fields);
        })->all();
    }
}
