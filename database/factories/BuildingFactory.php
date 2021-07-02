<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $buildingNumber = $this->faker->unique()->buildingNumber;
        return [
            'name' => implode($this->faker->words(rand(2,6))),
            'number' => "$buildingNumber",
            'number_of_offices' => $this->faker->numberBetween(100, 900),
            'description' => $this->faker->paragraph(rand(6, 10)),
        ];
    }
}
