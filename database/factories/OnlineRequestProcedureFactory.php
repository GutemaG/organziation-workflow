<?php

namespace Database\Factories;

use App\Models\OnlineRequestProcedure;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineRequestProcedureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineRequestProcedure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $description = Utility::getRandomValue([null, $this->faker->paragraph(rand(4,9))]);
        return [
            'responsible_bureau_id' => Utility::getBureauId(),
            'description' => $description,
            'step_number' => $this->faker->randomDigit(),
        ];
    }
}
