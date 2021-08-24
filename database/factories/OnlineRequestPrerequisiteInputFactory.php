<?php

namespace Database\Factories;

use App\Models\OnlineRequestPrerequisiteInput;
use App\Utilities\InputFieldType;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineRequestPrerequisiteInputFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineRequestPrerequisiteInput::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'input_id' => $this->faker->word(),
            'type' => InputFieldType::random(),
        ];
    }
}
