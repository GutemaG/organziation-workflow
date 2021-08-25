<?php

namespace Database\Factories;

use App\Models\OnlineRequestPrerequisiteNote;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnlineRequestPrerequisiteNoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineRequestPrerequisiteNote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'note' => $this->faker->sentence(rand(5,9)),
        ];
    }
}
