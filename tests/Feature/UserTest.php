<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\Utilities\Fields;
use App\Models\Permission;
use App\Models\User;
use Database\Factories\UserFactory;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use phpDocumentor\Reflection\Types\Integer;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUnauthenticatedUserCanAccess(){
        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);
    }

    private function checkResponseOfUnauthenticatedUser($response){
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }
}
