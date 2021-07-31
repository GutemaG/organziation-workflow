<?php

namespace Database\Factories;

use App\Models\PreRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use \App\Models\User;
use \App\Models\Affair;
use App\Models\Procedure;

class PreRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PreRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //Fields: [id, procedure_id, affair_id, name, description]
        $affairs_id = Affair::pluck('id');
        $procedures_id = Procedure::pluck('id')->toArray();
        $affair =$this->faker->randomElement($affairs_id, null);
        $name = '';
        $description='';
        if(empty($affair)){
           $name = Str::random(10);
           $description = Str::random(10);
        }
        else{

        }
        return [
            'affair_id'=>$affair,
            'procedure_id'=>$this->faker->randomElement($procedures_id),
            'name' =>$name,
            'description' =>$description,
        ];
    }
}
