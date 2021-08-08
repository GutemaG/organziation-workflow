<?php

namespace Database\Factories;

use App\Models\OnlineRequest;
use App\Utilities\RequestType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => Utility::getUserId(),
            'name' => implode($this->faker->unique()->words(rand(2, 5))),
            'type' => Utility::getRandomRequestType(),
            'description' => $this->faker->paragraph(rand(4, 10)),
        ];
    }
}
