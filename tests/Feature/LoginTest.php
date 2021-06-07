<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * hold admin data
     * @var
     */
    private $admin;

    /**
     * hold single it team member data
     * @var
     */
    private $itTeamMember;

    /**
     * setup before running each test
     * fetch admin data
     * fetch if test user with user name 'test_user_name' exist else it will create and fetch the data
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('user_name', 'nani')
            ->select(['id', 'user_name', 'first_name', 'last_name', 'email', 'phone', 'is_admin', 'is_active','created_at'])
            ->first();

        $this->itTeamMember = User::where('user_name', 'test_user_name')->first();
        if(empty($this->itTeamMember))
            $this->itTeamMember = User::create([
                'user_name' => 'test_user_name', 'first_name' => 'test_first_name', 'last_name' => 'test_last_name',
                'email' => 'test_email@gmail.com', 'phone' => '1234567878', 'is_active' => true,
                'is_admin' => false, 'password' => Hash::make('12345678'),])

                ->permission()->create(['delete_FAQ' => true, 'update_FAQ' => true, 'reply_request' => true,
                'add_request_to_FAQ' => true, 'delete_request' => true, 'create_bureau' => true,
                'update_bureau' => true, 'delete_bureau' => true, 'create_affair' => true,
                'update_affair' => true, 'delete_affair' => true,
            ]);
    }

    /**
     * test login with incorrect user name and password
     */
    public function testWithIncorrectUserNameAndPassword(){
        $response = $this->postJson('/api/login/', ['user_name' => 'henok', 'password' => 'fkdjkfjsdk']);
        $response->assertStatus(200);
        $response->assertJson([
           'status' => 400,
            'message' => 'incorrect user name or password',
        ]);

        $response = $this->postJson('/api/login/', ['user_name' => 'nani', 'password' => 'fkdjkfjsdk']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'message' => 'incorrect user name or password',
        ]);

        $response = $this->postJson('/api/login/', ['user_name' => 'henok', 'password' => '12345678']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'message' => 'incorrect user name or password',
        ]);
    }

    /**
     * test login with incorrect fields
     */
    public function testWithIncorrectFieldNames(){
        $response = $this->postJson('/api/login/', ['user_named' => 'henok', 'passwordd' => 'fkdjkfjsdk']);
        $response->assertJson([
            'status' => 400,
            'message' => [
                'user_name' => [
                    0 => 'The user name field is required.',
                ],
                'password' => [
                    0 => 'The password field is required.',
                ],
            ],
        ]);

        $response = $this->postJson('/api/login/', ['user_name' => 'henok', 'passwordd' => 'fkdjkfjsdk']);
        $response->assertJson([
            'status' => 400,
            'message' => [
                'password' => [
                    0 => 'The password field is required.',
                ],
            ],
        ]);

        $response = $this->postJson('/api/login/', ['user_named' => 'henok', 'password' => 'fkdjkfjsdk']);
        $response->assertJson([
            'status' => 400,
            'message' => [
                'user_name' => [
                    0 => 'The user name field is required.',
                ],
            ],
        ]);
    }

    /**
     * login with admin with correct user name and password
     * check if sanctum authentication works
     * check if the admin can fetch data
     * check if the admin can login for the second time by holding authentication token
     */
    public function testWithCorrectUserNameAndPassword(){
        $response = $this->postJson('/api/login/', ['user_name' => 'nani', 'password' => '12345678']);
        $response->assertStatus(200);

        $response->assertJson([
            'status' => 200,
            'message' => 'Successfully logged in',
            'user' => $this->returnedData(true),
        ]);
        Sanctum::actingAs($this->admin);
        $response = $this->getJson('/api/users/');
        $response->assertOk();
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
        ]);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('status')
            ->has('message')
            ->has('message.users.0', fn ($json) =>
            $json->where('id', $this->itTeamMember->id)
                ->where('user_name', $this->itTeamMember->user_name)
                ->missing('password')
                ->etc()
            )
        );

        $response = $this->postJson('/api/login/', ['user_name' => 'nani', 'password' => '12345678']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'you have already logged in',
        ]);
    }

    /**
     * login with it team member with correct user name and password
     * check if sanctum authentication works
     * check if the it team member can fetch data
     * check if the it team member can login for the second time by holding authentication token
     */
    public function testWithCorrectUserNameAndPasswordForItTeamMember(){
        $response = $this->postJson('/api/login/', ['user_name' => 'test_user_name', 'password' => '12345678']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'Successfully logged in',
            'user' => $this->returnedData(),
        ]);
        Sanctum::actingAs($this->itTeamMember);
        $response = $this->getJson('/api/users/');
        $response->assertOk();
        $response->assertJson([
            'status' => 401,
            'message' => 'Unauthorized',
        ]);

        $response = $this->postJson('/api/login/', ['user_name' => 'test_user_name', 'password' => '12345678']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 200,
            'message' => 'you have already logged in',
        ]);
    }

    /**
     * return data of admin or it team member
     * @param bool $is_admin
     * @return array
     */
    private function returnedData($is_admin=false){
        return [
            "id" => $is_admin ? $this->admin->id : $this->itTeamMember->id,
            "user_name" => $is_admin ? $this->admin->user_name : $this->itTeamMember->user_name,
            "first_name" => $is_admin ? $this->admin->first_name : $this->itTeamMember->first_name,
            "last_name" => $is_admin ? $this->admin->last_name : $this->itTeamMember->last_name,
            "email" => $is_admin ? $this->admin->email : $this->itTeamMember->email,
            "phone" => $is_admin ? $this->admin->phone : $this->itTeamMember->phone,
            "is_admin" => $is_admin ? $this->admin->is_admin : $this->itTeamMember->is_admin,
            "is_active" => $is_admin ? $this->admin->is_active : $this->itTeamMember->is_active,
        ];
    }
}
