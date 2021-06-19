<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\UserType;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Utilities\FakeDataGenerator;
use Tests\Feature\Utilities\Utility;
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

    private function getUser($type){
        if(! in_array($type, UserType::all()))
            return null;
        else
            return User::where('type', $type)->first();
    }

    private function assertUnauthorizedUser($response){
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 401,
            'error' => 'Unauthorized.',
        ]);
    }

    private function assertAllUrlsForStaffAndReceptionUsers($type){
        $this->actingAs($this->getUser($type));
        $response = $this->get('/api/users');
        $this->assertUnauthorizedUser($response);

        $response = $this->post('/api/users/', ['user_name' => 'henok']);
        $this->assertUnauthorizedUser($response);

        for ($i = 0; $i < 10; $i++){
            $users = User::orderBy('user_name', 'asc')->limit(10);
            foreach ($users as $user){
                $response = $this->get('/api/users/' . $user->id);
                $this->assertUnauthorizedUser($response);

                $response = $this->put('/api/users/' . $user->id, ['user_name' => 'henok']);
                $this->assertUnauthorizedUser($response);

                $response = $this->delete('/api/users/' . $user->id);
                $this->assertUnauthorizedUser($response);
            }
        }
    }

    public function testStaffCanAccessUsers(){
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getStaff());
    }

    public function testReceptionCanAccessUsers(){
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getReception());
    }

    public function testIndex(){
        $this->indexForAdminAndItTeamMember(UserType::getItTeamMember());

        $this->indexForAdminAndItTeamMember(UserType::getAdmin());
    }

    private function indexForAdminAndItTeamMember($type){
        $this->actingAs($this->getUser($type));
        $response = $this->get('/api/users/');
        if($type == UserType::getAdmin())
            $users = User::where('type', '!=', UserType::getAdmin())->orderBy('user_name', 'asc')->get();
        else
            $users = User::whereIn('type', [UserType::getStaff(), UserType::getReception()])->orderBy('user_name', 'asc')->get();
        $length = $users->count();
        $user = $users->first();
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('status')
            ->has('users', $length, fn ($json) =>
            $json->where('id', $user->id)
                ->where('user_name', $user->user_name)
                ->where('first_name', $user->first_name)
                ->where('last_name', $user->last_name)
                ->where('email', $user->email)
                ->where('phone', $user->phone)
                ->where('type', $user->type)
                ->has('deleted_at')
                ->has('created_at')
                ->missing('password')
            )
        );

    }

//    public function testPostForAdmin(){
//        $this->actingAs($this->getUser(UserType::getAdmin()));
//
//        $user = FakeDataGenerator::userData();
//        $response = $this->post('/api/users', $user);
//        $this->assertPostResponse($response, $user);
//
//        $user = FakeDataGenerator::userData();
//        $user['type'] = UserType::getAdmin();
//        $response = $this->post('/api/users', $user);
//        $response->assertStatus(200);
//        $response->assertJson([
//            'status' => 400,
//            'error' => ['type' => ['The selected type is invalid.']
//            ]
//        ]);
//
//        foreach (Utility::allCombinationOfUserData() as $fields){
//            $user = FakeDataGenerator::userDataOnly($fields);
//            $response = $this->post('/api/users', $user);
//            $fieldsMap = collect($fields)->map(function ($item, $key) {
//                return [$item => $item];
//            })->collapse();
//
//            if (collect($fieldsMap)->has(Fields::all())) {
//                $this->assertPostResponse($response, $user);
//            }
//            elseif (collect($fieldsMap)->has(Fields::except(['email']))){
//                $this->assertPostResponse($response, $user);
//            }
//            elseif (collect($fieldsMap)->has(Fields::except(['phone']))){
//                $this->assertPostResponse($response, $user);
//            }
//            elseif (collect($fieldsMap)->has(Fields::except(['email', 'phone']))){
//               $this->assertPostResponse($response, $user);
//            }
//            else{
//                $errors = Utility::getErrors(Fields::except($fields));
//                if(collect($fields)->contains('password') &&
//                    ! collect($fields)->contains('password_confirmation')){
//                    $errors['password'] = ["The password confirmation does not match."];
//                }
//                $response->assertJson([
//                    'status' => 400,
//                    'error' => $errors,
//                ]);
//            }
//        }
//    }

    private function assertPostResponse($response, $user=null, $isItTeam=false){
        if($isItTeam){
            if($user['type'] === UserType::getItTeamMember()){
                $response->assertStatus(200);
                $response->assertJson([
                    'status' => 400,
                    'error' => ['type' => 'You can\'t register user with admin or It team member privilege.']
                ]);
                return;
            }
        }
        $id = User::where('user_name', $user['user_name'])->first()->id;
        $data = [
            'id' => $id,
            "user_name" => $user['user_name'],
            "first_name" => $user['first_name'],
            "last_name" => $user['last_name'],
            "email" => array_key_exists('email', $user) ? $user['email'] : null,
            "phone" => array_key_exists('phone', $user) ? $user['phone'] : null,
            'type' => $user['type'],
        ];

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 201,
            'user' => $data,
        ]);
    }

//    public function testPostForItTeamMember(){
//        $this->actingAs($this->getUser(UserType::getItTeamMember()));
//
//        $user = FakeDataGenerator::userData();
//        $user['type'] = UserType::getStaff();
//        $response = $this->post('/api/users', $user);
//        $this->assertPostResponse($response, $user);
//
//        $user = FakeDataGenerator::userData();
//        $user['type'] = UserType::getReception();
//        $response = $this->post('/api/users', $user);
//        $this->assertPostResponse($response, $user);
//
//        $user = FakeDataGenerator::userData();
//        $user['type'] = UserType::getAdmin();
//        $response = $this->post('/api/users', $user);
//        $response->assertStatus(200);
//        $response->assertJson([
//            'status' => 400,
//            'error' => ['type' => ['The selected type is invalid.']
//            ]
//        ]);
//
//        foreach (Utility::allCombinationOfUserData() as $fields){
//            $user = FakeDataGenerator::userDataOnly($fields);
//            $response = $this->post('/api/users', $user);
//            $fieldsMap = collect($fields)->map(function ($item, $key) {
//                return [$item => $item];
//            })->collapse();
//
//            if (collect($fieldsMap)->has(Fields::all())) {
//               $this->assertPostResponse($response, $user, true);
//            }
//            elseif (collect($fieldsMap)->has(Fields::except(['email']))){
//                $this->assertPostResponse($response, $user, true);
//            }
//            elseif (collect($fieldsMap)->has(Fields::except(['phone']))){
//                $this->assertPostResponse($response, $user, true);
//            }
//            elseif (collect($fieldsMap)->has(Fields::except(['email', 'phone']))){
//                $this->assertPostResponse($response, $user, true);
//            }
//            else{
//                $errors = Utility::getErrors(Fields::except($fields));
//                if(collect($fields)->contains('password') &&
//                    ! collect($fields)->contains('password_confirmation')){
//                    $errors['password'] = ["The password confirmation does not match."];
//                }
//                $response->assertJson([
//                    'status' => 400,
//                    'error' => $errors,
//                ]);
//            }
//        }
//    }

    public function testShowForAdmin(){
        $this->actingAs($this->getUser(UserType::getAdmin()));
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $response = $this->get('/api/users/' . $user->id);

            if($user->type == UserType::getAdmin()){
                $this->assertShowForAdminAndItTeamMember($response);
            }
            else
                $this->assertShowForAdminAndItTeamMember($response, $user, true);
        }
    }

    public function testShowForItTeamMember(){
        $this->actingAs($this->getUser(UserType::getItTeamMember()));
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $response = $this->get('/api/users/' . $user->id);

            if($user->type == UserType::getAdmin() || $user->type == UserType::getItTeamMember()){
                $this->assertShowForAdminAndItTeamMember($response);
            }
            else
                $this->assertShowForAdminAndItTeamMember($response, $user, true);
        }
    }

    private function getAllTypeOfUsers(){
        $users = collect([]);
        foreach (UserType::all() as $item){
            $users->add(User::where('type', $item)->limit(10)->get());
        }
        return $users->collapse()->all();
    }

    private function assertShowForAdminAndItTeamMember($response, $user=null, $isValid=false){
        $response->assertStatus(200);
        if (! $isValid){
            $response->assertJson([
                'status' => 404,
                'error' => 'user doesn\'t exist',
            ]);
        }
        else{
            $response->assertJson([
                'status' => 200,
                'user' =>  [
                    'id' => $user->id,
                    "user_name" => $user->user_name,
                    "first_name" => $user->first_name,
                    "last_name" => $user->last_name,
                    "email" => $user->email,
                    "phone" => $user->phone,
                    'type' => $user->type,
                ]
            ]);
        }
    }

    public function testUpdate(){
        $this->actingAs($this->getUser(UserType::getAdmin()));
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $response = $this->put('/api/users/' . $user->id, []);


        }
    }

    public function testDestroyForAdmin(){
        $this->actingAs($this->getUser(UserType::getAdmin()));
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $response = $this->delete('/api/users/' . $user->id);

            if($user->type == UserType::getAdmin()){
                $response->assertStatus(200);
                $response->assertJson([
                    'status' => 400,
                    'error' => 'Bad request.',
                ]);
            }
            else {
                $response->assertStatus(200);
                $response->assertJson([
                    'status' => 200,
                ]);
            }
        }
    }

    public function testDestroyForItTeamMember(){
        $this->actingAs($this->getUser(UserType::getItTeamMember()));
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $response = $this->delete('/api/users/' . $user->id);

            if(in_array($user->type, [UserType::getAdmin(), UserType::getItTeamMember()])){
                $response->assertStatus(200);
                $response->assertJson([
                    'status' => 400,
                    'error' => 'Bad request.',
                ]);
            }
            else {
                $response->assertStatus(200);
                $response->assertJson([
                    'status' => 200,
                ]);
            }
        }
    }

}
