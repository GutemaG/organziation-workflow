<?php

namespace Database\Factories;

use App\Models\Procedure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use \App\Models\Affair;
class ProcedureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Procedure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //Fields: [id, affair_id, name, description, step]
        $affairs_id = Affair::pluck('id')->toArray();

        return [
            'affair_id' => $this->faker->randomElement($affairs_id),
            'name' =>Str::random(10),
            'description' =>Str::random(30),
            'step' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10])
        ];
    }
}
