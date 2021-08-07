<?php

namespace Database\Factories;

use App\Models\Affair;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \App\Models\User;
use App\Utilities\RequestType;
class AffairFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Affair::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        //Fields: [id,user_id, name, description, timestamp,]
        $users_id = User::where('type', 'admin')->orWhere('type', 'it_team_member')
                    ->pluck('id')->toArray();
        return [
            'user_id'=>$this->faker->randomElement($users_id),
            'name' => implode($this->faker->unique()->words(rand(4, 7))),
             'type' => Utility::getRandomRequestType(),
            'description' => $this->faker->paragraph(rand(4, 10)),

        ];
    }
}
