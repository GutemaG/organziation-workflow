<?php

namespace Database\Factories;

use App\Http\Controllers\Api\Utilities\Fields;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return collect(Fields::$permission_fields)->map(function ($item, $key) {
            return [$item => random_int(0,1)];
        })->collapse()->all();
    }
}
