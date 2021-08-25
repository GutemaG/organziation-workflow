<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\Http\Controllers\Utilities\UserType;
use App\Models\User;
use Tests\Feature\Utilities\FakeDataGenerator;

class AccountTest extends MyTestCase
{
    protected string $url = '/api/account/';
    protected bool $defaultTest = false;

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

    public function testChangePassword() {
        foreach ($this->getAllTypeOfUsers() as $user) {
            $this->actingAs($user);
            $response = $this->post($this->url . 'change-password', []);
            $response->assertStatus(200);
            $this->assertAuthenticatedAs($user);
            $response->assertJson([
                'status' => 400,
                'error' => [
                    'current_password' => ['The current password field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);

            $response = $this->post($this->url . 'change-password', ['current_password' => 'djfksdjfkj', 'password' => 'test']);
            $response->assertStatus(200);
            $this->assertAuthenticatedAs($user);
            $response->assertJson([
                'status' => 400,
                'error' => [
                    'password' => [
                        "The password confirmation does not match.",
                        "The password must be at least 8 characters."
                    ]
                ]
            ]);

            $response = $this->post($this->url . 'change-password', ['current_password' => 'gdgdgdfg', 'password' => '12345678', 'password_confirmation' => '12345678']);
            $response->assertStatus(200);
            $this->assertAuthenticatedAs($user);
            $response->assertJson([
                'status' => 400,
                'error' => [
                    'current_password' => ["The password you entered didn't match with current password."]
                ]
            ]);

            $currentPassword = $user->type == UserType::admin() ? 'laravel1234' : '12345678';
            $response = $this->post($this->url . 'change-password', ['current_password' => $currentPassword, 'password' => '12345678', 'password_confirmation' => '12345678']);
            $response->assertStatus(200);
            $this->assertAuthenticatedAs($user);
            $response->assertJson([
                'status' => 200,
            ]);
        }
        $this->restoreAdmin();
    }

    private function restoreAdmin(){
        User::where('type', UserType::admin())->first()->update([
            'user_name' => 'admin',
            'first_name' =>'birhanu',
            'last_name' => 'Gudisa',
            'email' => 'owgs@astu.com',
            'password' => Hash::make('laravel1234'),
        ]);
    }
}
