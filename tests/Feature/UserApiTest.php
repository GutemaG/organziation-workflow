<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\Utilities\Fields;
use App\Models\Permission;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserApiTest extends TestCase
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
     * create random it member
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('user_name', 'nani')
            ->select(['id', 'user_name', 'first_name', 'last_name', 'email', 'phone', 'is_admin', 'is_active'])
            ->first();

        $this->itTeamMember = User::where('user_name', 'test_user_name')->first();
        if(empty($this->itTeamMember))
            $this->itTeamMember = User::create([
                'user_name' => 'test_user_name', 'first_name' => 'test_first_name', 'last_name' => 'test_last_name',
                'email' => 'test_email@gmail.com', 'phone' => '$123456user->id8user->id8', 'is_active' => true,
                'is_admin' => false, 'password' => Hash::make('$123456user->id8'),])

                ->permission()->create(['delete_FAQ' => true, 'update_FAQ' => true, 'reply_request' => true,
                    'add_request_to_FAQ' => true, 'delete_request' => true, 'create_bureau' => true,
                    'update_bureau' => true, 'delete_bureau' => true, 'create_affair' => true,
                    'update_affair' => true, 'delete_affair' => true,
                ]);
        $user = User::factory()->create();
        Permission::factory()->create([
            'user_id' => $user->id,
        ]);
    }

    public function testUnauthorizedUserCanAccess(){
        $response = $this->getJson('/api/users');
        $this->checkStatusAndJsonValue($response);

        $response = $this->postJson('/api/users', ['user_name' => 'henok', 'password' => 'kickstands']);
        $this->checkStatusAndJsonValue($response);

        $response = $this->putJson('/api/users/2/', ['first_name' => 'henok']);
        $this->checkStatusAndJsonValue($response);

        $response = $this->getJson('/api/users/2');
        $this->checkStatusAndJsonValue($response);

        $response = $this->deleteJson('/api/users/2');
        $this->checkStatusAndJsonValue($response);
    }

    private function checkStatusAndJsonValue($response, $isLoggedin=false){
        if(!$isLoggedin){
            $response->assertStatus(401);
            $response->assertJson([
                'message' => 'Unauthenticated.'
            ]);
        }
        else{
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 401,
                'message' => 'Unauthorized',
            ]);
        }
    }

    public function testItMemberUserRequest(){
        Sanctum::actingAs($this->itTeamMember);

        $response = $this->getJson('/api/users');
        $this->checkStatusAndJsonValue($response, true);

        $response = $this->postJson('/api/users', ['user_name' => 'henok', 'password' => 'kickstands']);
        $this->checkStatusAndJsonValue($response, true);

        $response = $this->putJson('/api/users/2/', ['first_name' => 'henok']);
        $this->checkStatusAndJsonValue($response, true);

        $response = $this->getJson('/api/users/2');
        $this->checkStatusAndJsonValue($response, true);

        $response = $this->deleteJson('/api/users/2');
        $this->checkStatusAndJsonValue($response, true);
    }

    public function testListUsers(){
        Sanctum::actingAs($this->admin);
        $count = User::where('is_admin', false)->get()->count();
        $user = User::where('is_admin', false)->orderBy('user_name', 'asc')->first();
        $response = $this->getJson('/api/users');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('status')
            ->has('message', 1)
            ->has('message.users', $count
                , fn ($json) =>
                $json->where('id', $user->id)
                    ->where('user_name', $user->user_name)
                    ->where('first_name', $user->first_name)
                    ->where('last_name', $user->last_name)
                    ->where('email', $user->email)
                    ->where('phone', $user->phone)
                    ->where('is_admin', $user->is_admin)
                    ->where('is_active', $user->is_active)
                    ->missing('password')
            )
        );
    }

    private function userDataGenerator(){
        $faker = Factory::create();
        return [
            'user_name' => $faker->unique()->name(),
            'first_name' => $faker->name(),
            'last_name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'is_active' => true,
            'is_admin' => false,
            'email_verified_at' => now(),
            'password' => '123456user->id8',
            'password_confirmation' => '123456user->id8',
            'remember_token' => Str::random(10),
        ];
    }

    private function userPermissionDataGenerator(){
        return collect(Fields::$permission_fields)->map(function ($item, $key) {
            return [$item => random_int(0,1)];
        })->collapse()->all();
    }

    private function getUserData($except=[]){
        $data = array_merge($this->userDataGenerator(), $this->userPermissionDataGenerator());

        if(empty($except))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($except) {
            return !in_array($key, $except);
        })->all();
    }

    private function errors(){
        return [
            'user_name' => [
                "The user name field is required."
            ],
            'first_name' => [
                "The first name field is required."
            ],
            'last_name' => [
                "The last name field is required."
            ],
            'password' => [
                "The password field is required."
            ],
            "delete_FAQ" => [
                "The delete  f a q field is required."
            ],
            "update_FAQ" => [
                "The update  f a q field is required."
            ],
            "reply_request" => [
                "The reply request field is required."
            ],
            "add_request_to_FAQ" => [
                "The add request to  f a q field is required."
            ],
            "delete_request" => [
                "The delete request field is required."
            ],
            "create_bureau" => [
                "The create bureau field is required."
            ],
            "update_bureau" => [
                "The update bureau field is required."
            ],
            "delete_bureau" => [
                "The delete bureau field is required."
            ],
            "create_affair" => [
                "The create affair field is required."
            ],
            "update_affair" => [
                "The update affair field is required."
            ],
            "delete_affair" => [
                "The delete affair field is required."
            ]
        ];
    }

    private function getErrors($except){
        return collect($this->errors())->filter(function ($value, $key) use ($except) {
            return in_array($key, $except);
        })->all();
    }

    private function permutation(){
        $list = Fields::all();
        $result = array();
        $temp = array();
        foreach ($list as $value){
            if (!in_array($value, $temp))
                array_push($temp, $value);
            foreach ($temp as $item){
                if($item != $value)
                    $result[] = array($item, $value);
            }
        }
        return $result;
    }

    private function checkErrors($count){
        Sanctum::actingAs($this->admin);
        $start = 0;
        $end = 153;
        switch ($count){
            case 1:
                $start = 0;
                $end = 50;
                break;
            case 2:
                $start = 49;
                $end = 100;
                break;
            case 3:
                $start = 99;
                $end = count((array) $this->permutation());
                break;
        }

        $fields = $this->permutation();
        for ($i = $start; $i < $end; $i++) {
            $except = $fields[$i];
            $data = $this->getUserData($except);
            $response = $this->postJson('/api/users/', $data);
            $response->assertStatus(200);
            if(in_array('email', $except) && in_array('phone', $except)){
                $response->assertJson([
                    'status' => 201,
                    'message' => 'user registered successfully',
                ]);
            }
            else{
                $response->assertJson([
                    'status' => 400,
                    'message' => [
                        'error' => $this->getErrors($except),
                    ],
                ]);
            }

        }
    }

    public function testStoreUserWithIncompleteField1(){
        $this->checkErrors(1);
    }

    public function testStoreUserWithIncompleteField2(){
        $this->checkErrors(2);
    }

    public function testStoreUserWithIncompleteField3(){
        $this->checkErrors(3);
    }

    public function testStoreUser(){
        Sanctum::actingAs($this->admin);

        $data = $this->getUserData();
        $response = $this->postJson('/api/users/', $data);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 201,
            'message' => 'user registered successfully',
        ]);

        $data = $this->getUserData(['password_confirmation']);
        $response = $this->postJson('/api/users/', $data);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'message' => [
                'error' => [
                    'password' => [
                        'The password confirmation does not match.',
                    ]
                ],
            ],
        ]);

        $response = $this->postJson('/api/users/', ['name' => 'henok', 'test' => 'test']);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'message' => [
                'error' => $this->errors(),
            ],
        ]);
    }

    public function testShowUser(){
        Sanctum::actingAs($this->admin);
        $users = User::where('is_admin', false)->with(['permission'])->get();
        $length = count($users) - 1;
        for ($i = 0; $i < 10; $i++){
            $index = random_int(0, $length);
            $user = $users[$index];
            $response = $this->getJson('/api/users/' . $user->id);
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 200,
                'message' => 'success',
                'user' => [
                    "id" => $user->id,
                    "user_name" => $user->user_name,
                    "first_name" => $user->first_name,
                    "last_name" => $user->last_name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    "is_admin" => $user->is_admin,
                    "is_active" => $user->is_active,
                    "permission" => [
                        "id" => $user->permission->id,
                        "user_id" => $user->permission->user_id,
                        "delete_FAQ" => $user->permission->delete_FAQ,
                        "update_FAQ" => $user->permission->update_FAQ,
                        "reply_request" => $user->permission->reply_request,
                        "add_request_to_FAQ" => $user->permission->add_request_to_FAQ,
                        "delete_request" => $user->permission->delete_request,
                        "create_bureau" => $user->permission->create_bureau,
                        "update_bureau" => $user->permission->update_bureau,
                        "delete_bureau" => $user->permission->delete_bureau,
                        "create_affair" => $user->permission->create_affair,
                        "update_affair" => $user->permission->update_affair,
                        "delete_affair" => $user->permission->delete_affair,
                    ]
                ]
            ]);
        }
    }

    public function testDestroy(){
        Sanctum::actingAs($this->admin);
        $users = User::where('is_admin', false)->with(['permission'])->get();
        $length = count($users) - 1;
        for ($i = 0; $i < 1; $i++){
            $index = random_int(0, $length);
            $user = $users[$index];
            $response = $this->deleteJson('/api/users/' . $user->id );
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 200,
                'message' => 'user delete successfully',
            ]);

            $response = $this->deleteJson('/api/users/' . $user->id );
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 404,
                'message' => 'user doesn\'t exist',
            ]);
        }
    }
}
