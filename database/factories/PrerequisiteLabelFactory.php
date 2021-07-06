<?php

namespace Database\Factories;

use App\Models\PrerequisiteLabel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrerequisiteLabelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrerequisiteLabel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'online_request_id' => Utility::getOnlineRequestId(),
            'label' => $this->faker->sentence(rand(8, 12)),
        ];
    }
}
