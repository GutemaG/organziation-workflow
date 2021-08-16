<?php

namespace Database\Factories;

use App\Models\Procedure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \App\Models\Bureau;

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

        $bureau_ids = Bureau::pluck('id')->toArray();
        return [
            'affair_id' => $this->faker->randomElement($affairs_id),
            'name' => implode($this->faker->unique()->words(rand(4, 7))),
            'description' => $this->faker->paragraph(rand(4, 10)),
            'responsible_bureau_id' => $this->faker->randomElement($bureau_ids),
            'step' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10])
        ];
    }
}
