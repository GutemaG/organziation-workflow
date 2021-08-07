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
        $affair_ids = Affair::pluck('id');
        $procedures_id = Procedure::pluck('id')->toArray();
        $affair_id =$this->faker->randomElement($affair_ids, null);
        $name = '';
        $description='';
        if(empty($affair)){
            $name = $this->faker->paragraph(rand(2, 4));
            $description = $this->faker->paragraph(rand(4, 10));
        }
        else{
            $name = '';
            $description ='';
        }
        return [
            'affair_id'=>$affair_id,
            'procedure_id'=>$this->faker->randomElement($procedures_id),
            'name' =>$name,
            'description' =>$description,
        ];
    }
}
