<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Http\Controllers\Utilities\UserType;
use App\Models\User;
use Tests\Feature\Utilities\FakeDataGenerator;

class AccountTest extends TestCase
{
    public function testCanUnauthenticatedUserCanUpdateAccount(){
        $response = $this->post('/api/account', FakeDataGenerator::userData());
        $response->assertRedirect(route('login'));
        $response->assertStatus(302);
    }

    private function getAllTypeOfUsers(){
        $users = collect([]);
        foreach (UserType::all() as $item){
            $users->add(User::where('type', $item)->limit(10)->get());
        }
        return $users->collapse()->all();
    }

    public function  testAuthenticatedUserCanUpdateHisOwnAccount(){
        foreach ($this->getAllTypeOfUsers() as $user){
            $this->assertWithValidData($user);
            $this->assertWithInvalidData($user);
            $this->restoreAdmin();
        }
    }

    private function assertWithValidData(User $user){
        $this->actingAs($user);
        $data = FakeDataGenerator::userDataExcept(['password', 'password_confirmation', 'type']);
        $response = $this->post('/api/account', $data);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
        ]);
        $this->assertDatabaseHas(User::class, $data);
    }

    private function assertWithInvalidData(User $user)
    {
        $this->actingAs($user);
        $data = FakeDataGenerator::userDataExcept(['password', 'password_confirmation', 'type']);
        $errors = [];
        $nullableFields = ['email', 'phone'];

        foreach ($data as $field => $value){
            $data[$field] = null;
            $name = $this->getFieldHumanReadableName($field);

            if (! in_array($field, $nullableFields)){
                in_array($field, $errors) ? null : $errors[$field] = [];
                array_push($errors[$field], "The $name field is required.");
            }

            $response = $this->post('/api/account', $data);
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 400,
                'error' => $errors,
            ]);
        }

        $response = $this->post('/api/account', ['email' => 'test']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'error' => [
                'email' => ['The email must be a valid email address.']
            ],
        ]);
    }

    private function getFieldHumanReadableName($field){
        return str_replace('_', ' ', $field);
    }

    private function restoreAdmin(){
        User::where('type', UserType::admin())->first()->update([
            'user_name' => 'admin',
            'first_name' =>'birhanu',
            'last_name' => 'Gudisa',
            'email' => 'owgs@astu.com',
        ]);
    }
}
