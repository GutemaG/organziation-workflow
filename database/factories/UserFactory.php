<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_name' => $this->faker->unique()->firstName(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
<<<<<<< HEAD
            'is_active' => true,
            'is_admin' => false,
            'email_verified_at' => now(),
            'phone' => $this->faker->phoneNumber(),
=======
            'phone' => Utility::getPhoneNumber(),
            'type' => Utility::getUserType(),
>>>>>>> master
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
