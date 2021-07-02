<?php

namespace Database\Factories;

use App\Models\Bureau;
use Illuminate\Database\Eloquent\Factories\Factory;

class BureauFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bureau::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $latitude = $this->faker->latitude();
        $longitude = $this->faker->longitude();
        $data = Utility::getBuildingNumberAndOfficeNumber();
        $buildingNumber = $data['building_number'];
        $officeNumber = $data['office_number'];
        $sentences = $this->faker->sentences(rand(5, 16));
        $paragraph = implode($sentences);

        return [
            'user_id' => Utility::getUserId(),
            'name' => $this->faker->unique()->name(),
            'description' => $paragraph,
            'accountable_to' => Utility::getBureauId(),
            'location' => Utility::getLocation($latitude, $longitude),
            'building_number' => $buildingNumber,
            'office_number' => "$officeNumber",
        ];
    }
}
