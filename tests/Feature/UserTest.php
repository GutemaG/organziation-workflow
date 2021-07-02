<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Utilities\FakeDataGenerator;
use Tests\Feature\Utilities\Utility;
use Tests\TestCase;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\UserType;
use App\Models\User;


class UserTest extends TestCase
{
    private function printSuccessMessage($message){
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n</info>");
        print_r("<info>  $message --- success.  \n</info>");
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n\n\n</info>");
    }

    public function testUnauthenticatedUserCanAccess(){
        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);
        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/users');
        $this->checkResponseOfUnauthenticatedUser($response);
        $this->printSuccessMessage('unauthenticated user can access users or store user');
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
        $this->printSuccessMessage('authenticated staff can access any user or can store user');

    }

    public function testReceptionCanAccessUsers(){
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getReception());
        $this->printSuccessMessage('authenticated reception can access any user or can store user');
    }

    public function testIndex(){
        $this->indexForAdminAndItTeamMember(UserType::getAdmin());
        $this->printSuccessMessage('list all users; by logging with admin');

        $this->indexForAdminAndItTeamMember(UserType::getItTeamMember());
        $this->printSuccessMessage('list all users; by logging with it team member');
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

    public function testPostForAdmin(){
        $this->actingAs($this->getUser(UserType::getAdmin()));

        $user = FakeDataGenerator::userData();
        $response = $this->post('/api/users', $user);
        $this->assertPostResponse($response, $user);

        $user = FakeDataGenerator::userData();
        $user['type'] = UserType::getAdmin();
        $response = $this->post('/api/users', $user);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'error' => ['type' => ['The selected type is invalid.']
            ]
        ]);

        $tableName = 'user';
        foreach (Utility::allCombinationOfUserData() as $fields){
            $user = FakeDataGenerator::userDataOnly($fields);
            $response = $this->post('/api/users', $user);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(Fields::all())) {
                $this->assertPostResponse($response, $user);
            }
            elseif (collect($fieldsMap)->has(Fields::except($tableName, ['email']))){
                $this->assertPostResponse($response, $user);
            }
            elseif (collect($fieldsMap)->has(Fields::except($tableName, ['phone']))){
                $this->assertPostResponse($response, $user);
            }
            elseif (collect($fieldsMap)->has(Fields::except($tableName, ['email', 'phone']))){
               $this->assertPostResponse($response, $user);
            }
            else{
                $errors = Utility::getErrors(Fields::except($tableName, $fields));
                if(collect($fields)->contains('password') &&
                    ! collect($fields)->contains('password_confirmation')){
                    $errors['password'] = ["The password confirmation does not match."];
                }
                $response->assertJson([
                    'status' => 400,
                    'error' => $errors,
                ]);
            }
        }
        $this->printSuccessMessage('store user; by logging with admin');
    }

    private function assertPostResponse($response, $user=null, $isItTeam=false){
        if($isItTeam){
            if($user['type'] === UserType::getItTeamMember()){
                $response->assertStatus(200);
                $response->assertJson([
                    'status' => 400,
                    'error' => ['type' => ['You can\'t register user with admin or It team member privilege.']]
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

    public function testPostForItTeamMember(){
        $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $user = FakeDataGenerator::userData();
        $user['type'] = UserType::getStaff();
        $response = $this->post('/api/users', $user);
        $this->assertPostResponse($response, $user);

        $user = FakeDataGenerator::userData();
        $user['type'] = UserType::getReception();
        $response = $this->post('/api/users', $user);
        $this->assertPostResponse($response, $user);

        $user = FakeDataGenerator::userData();
        $user['type'] = UserType::getAdmin();
        $response = $this->post('/api/users', $user);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'error' => ['type' => ['The selected type is invalid.']
            ]
        ]);

        $tableName = 'user';
        foreach (Utility::allCombinationOfUserData() as $fields){
            $user = FakeDataGenerator::userDataOnly($fields);
            $response = $this->post('/api/users', $user);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(Fields::all())) {
               $this->assertPostResponse($response, $user, true);
            }
            elseif (collect($fieldsMap)->has(Fields::except($tableName, ['email']))){
                $this->assertPostResponse($response, $user, true);
            }
            elseif (collect($fieldsMap)->has(Fields::except($tableName, ['phone']))){
                $this->assertPostResponse($response, $user, true);
            }
            elseif (collect($fieldsMap)->has(Fields::except($tableName, ['email', 'phone']))){
                $this->assertPostResponse($response, $user, true);
            }
            else{
                $errors = Utility::getErrors(Fields::except($tableName, $fields));
                if(collect($fields)->contains('password') &&
                    ! collect($fields)->contains('password_confirmation')){
                    $errors['password'] = ["The password confirmation does not match."];
                }
                $response->assertJson([
                    'status' => 400,
                    'error' => $errors,
                ]);
            }
        }
        $this->printSuccessMessage('store user; by logging with it team member');
    }

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
            $this->printSuccessMessage('show all type of users; by logging with admin');
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
        $this->printSuccessMessage('show all type of users; by logging with it team member');
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
                'error' => 'Bad request.',
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

    public function testUpdateForAdmin(){
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $this->updateWithInvalidEmailAndInvalidType($user, UserType::getAdmin());
            $this->printSuccessMessage('update users with invalid email and invalid type; by logging with admin');
            $this->updateValidFieldsAndValues($user, UserType::getAdmin());
            $this->printSuccessMessage('update users with valid fields and values; by logging with admin');
        }
    }

    public function updateForItTeamMember(){
        $users = $this->getAllTypeOfUsers();

        foreach ($users as $user){
            $this->updateWithInvalidEmailAndInvalidType($user, UserType::getItTeamMember());
            $this->printSuccessMessage('update users with invalid email and invalid type; by logging with it team member');
            $this->updateValidFieldsAndValues($user, UserType::getItTeamMember());
            $this->printSuccessMessage('update users with valid fields and values; by logging with it team member');
        }
    }

    private function updateValidFieldsAndValues($user, $type){
        if($type == UserType::getAdmin())
            $this->actingAs($this->getUser(UserType::getAdmin()));
        else
            $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $data = FakeDataGenerator::userDataExcept(['password_confirmation', 'password']);
        foreach ($data as $key => $value){
            $response = $this->put('/api/users/' . $user->id, [$key => '']);
            $response->assertStatus(200);
            if($user->type == UserType::getAdmin()){
                $this->assertUpdate(1, $response);
            }
            elseif (in_array($key, ['phone', 'email'])){
                $user = $this->assertUpdate(3, $response, $key, '', $user);
            }
            else {
                $this->assertUpdate(2, $response, $key);
            }

            $response = $this->put('/api/users/' . $user->id, [$key => $value]);
            $response->assertStatus(200);
            if($user->type == UserType::getAdmin()){
                $this->assertUpdate(1, $response);
            }
            else{
                $user = $this->assertUpdate(3, $response, $key, $value, $user);
            }
        }
    }

    private function updateWithInvalidEmailAndInvalidType($user, $type){
        if($type == UserType::getAdmin())
            $this->actingAs($this->getUser(UserType::getAdmin()));
        else
            $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $response = $this->put('/api/users/' . $user->id, ['email' => 'test']);
        if($user->type == UserType::getAdmin()){
            $this->assertUpdate(1, $response);
        }
        else{
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 400,
                'error' => [
                    'email' => ["The email must be a valid email address."]
                ]
            ]);
        }

        $response = $this->put('/api/users/' . $user->id, ['type' => 'admin']);
        if($user->type == UserType::getAdmin()){
            $this->assertUpdate(1, $response);
        }
        else{
            $response->assertStatus(200);
            $response->assertJson([
                'status' => 400,
                'error' => [
                    'type' => ["You can't assassin user with admin privilege."]
                ]
            ]);
        }
    }

    private function assertUpdate($case, $response, $key=null, $value=null, $user=null){
        switch ($case){
            case 1:
                $response->assertJson( [
                    'status' => 400,
                    'error' => 'Bad request.',
                ]);
                break;
            case 2:
                $response->assertJson([
                    'status' => 400,
                    'error' => Utility::getErrors([$key]),
                ]);
                break;
            case 3:
                $user = $this->changeUserValue($key, $value, $user);
                $response->assertJson( [
                    'status' => 200,
                    'user' => [
                        'id' => $user->id,
                        "user_name" => $user->user_name,
                        "first_name" => $user->first_name,
                        "last_name" => $user->last_name,
                        "email" => $user->email,
                        "phone" => $user->phone,
                        'type' => $user->type,
                    ],
                ]);
                return $user;
        }
    }

    private function changeUserValue($attribute, $value, $user){
        switch ($attribute){
            case 'user_name':
                $user->user_name = $value;
                break;
            case 'first_name':
                $user->first_name = $value;
                break;
            case 'last_name':
                $user->last_name = $value;
                break;
            case 'email':
                $user->email = $value;
                break;
            case 'phone':
                $user->phone = $value;
                break;
            case 'type':
                $user->type = $value;
                break;
        }
        return $user;
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
        $this->restoreDeletedUsers();
        $this->printSuccessMessage('destroy users by logging with admin');
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
        $this->printSuccessMessage('destroy users by logging with it team member');

        $this->restoreDeletedUsers();
        $this->printSuccessMessage('restoring deleted users');
    }

    private function restoreDeletedUsers(){
        User::withTrashed()->restore();
        $this->printSuccessMessage('all users deleted restored');
    }

}
