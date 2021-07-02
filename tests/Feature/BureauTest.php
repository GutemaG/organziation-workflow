<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\UserType;
use App\Models\Bureau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Utilities\Error;
use Tests\Feature\Utilities\FakeDataGenerator;
use Tests\Feature\Utilities\Utility;
use Tests\TestCase;

class BureauTest extends TestCase
{
    private $url = '/api/bureaus/';

    private function printSuccessMessage($message){
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n</info>");
        print_r("<info>  $message --- success.  \n</info>");
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n\n\n</info>");
    }

    private function getUser($type){
        if(! in_array($type, UserType::all()))
            return null;
        else
            return User::where('type', $type)->first();
    }
//
//    public function testUnauthenticatedUserCanAccess(){
//        $response = $this->get($this->url);
//        $this->checkResponseOfUnauthenticatedUser($response);
//        $response = $this->post($this->url);
//        $this->checkResponseOfUnauthenticatedUser($response);
//
//        $response = $this->get($this->url . '1/');
//        $this->checkResponseOfUnauthenticatedUser($response);
//
//        $response = $this->put($this->url . '1/', []);
//        $this->checkResponseOfUnauthenticatedUser($response);
//
//        $response = $this->delete($this->url . '1/');
//        $this->checkResponseOfUnauthenticatedUser($response);
//        $this->printSuccessMessage('unauthenticated user can access buildings or store buildings');
//    }
//
//    private function checkResponseOfUnauthenticatedUser($response){
//        $response->assertRedirect(route('login'));
//        $response->assertStatus(302);
//    }
//
//    private function assertUnauthorizedUser($response){
//        $response->assertStatus(200);
//        $response->assertJson([
//            'status' => 401,
//            'error' => 'Unauthorized.',
//        ]);
//    }
//
//    private function assertAllUrlsForStaffAndReceptionUsers($type){
//        $this->actingAs($this->getUser($type));
//        $response = $this->get($this->url);
//        $this->assertUnauthorizedUser($response);
//
//        $response = $this->post($this->url, []);
//        $this->assertUnauthorizedUser($response);
//
//        for ($i = 0; $i < 10; $i++){
//            $bureaus = Bureau::orderBy('name', 'asc')->limit(10);
//            foreach ($bureaus as $bureau){
//                $response = $this->get($this->url . $bureau->id);
//                $this->assertUnauthorizedUser($response);
//
//                $response = $this->put($this->url . $bureau->id, []);
//                $this->assertUnauthorizedUser($response);
//
//                $response = $this->delete($this->url . $bureau->id);
//                $this->assertUnauthorizedUser($response);
//            }
//        }
//    }
//
//    public function testStaffCanAccessUsers(){
//        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getStaff());
//        $this->printSuccessMessage('authenticated staff can access any buildings or can store buildings');
//
//    }
//
//    public function testReceptionCanAccessUsers(){
//        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getReception());
//        $this->printSuccessMessage('authenticated reception can access any buildings or can store buildings');
//    }
//
//    public function testIndex(){
//        $this->indexForAdminAndItTeamMember(UserType::getAdmin());
//        $this->printSuccessMessage('list all bureau; by logging with admin');
//
//        $this->indexForAdminAndItTeamMember(UserType::getItTeamMember());
//        $this->printSuccessMessage('list all bureau; by logging with it team member');
//    }
//
//    private function indexForAdminAndItTeamMember($type){
//        $this->actingAs($this->getUser($type));
//        $response = $this->get($this->url);
//        $bureaus = Bureau::orderBy('name', 'asc')->get();
//        $length = $bureaus->count();
//        $bureau = $bureaus->first();
//        $response->assertJson(fn (AssertableJson $json) =>
//        $json->has('status')
//            ->has('bureaus', $length, fn ($json) =>
//            $json->where('id', $bureau->id)
//                ->where('user_id', $bureau->user_id)
//                ->where('name', $bureau->name)
//                ->where('description', $bureau->description)
//                ->where('location', $bureau->location)
//                ->where('accountable_to', $bureau->accountable_to)
//                ->where('building_number', $bureau->building_number)
//                ->where('office_number', $bureau->office_number)
//                ->has('created_at')
//                ->missing('updated_at')
//                ->missing('deleted_at')
//            )
//        );
//    }

    public function testPostForAdmin(){
        $user = $this->getUser(UserType::getAdmin());
        $this->actingAs($user);

        $bureau = FakeDataGenerator::bureauData();
        $response = $this->post($this->url, $bureau);
        $this->assertPostResponse($response, $bureau, $user->id);

        foreach (Fields::allCombinationModelFields('bureau') as $fields) {
            $data = FakeDataGenerator::only('bureau', $fields);
            $response = $this->post($this->url, $data);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(Fields::except('bureau', ['location', 'accountable_to']))) {
                $this->assertPostResponse($response, $data, $user->id);
            }
            else{
                $error = Error::only('bureau', Fields::except('bureau', $fields));
                $response->assertJson([
                    'status' => 400,
                    'error' => $error,
                ]);
            }
        }
        $this->printSuccessMessage('store bureau; by logging with admin');
    }

    public function testPostForItTeamMember(){
        $user = $this->getUser(UserType::getItTeamMember());
        $this->actingAs($user);

        $bureau = FakeDataGenerator::bureauData();
        $response = $this->post($this->url, $bureau);
        $this->assertPostResponse($response, $bureau, $user->id);

        foreach (Fields::allCombinationModelFields('bureau') as $fields) {
            $data = FakeDataGenerator::only('bureau', $fields);
            $response = $this->post($this->url, $data);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(Fields::except('bureau', ['location', 'accountable_to']))) {
                $this->assertPostResponse($response, $data, $user->id);
            }
            else{
                $error = Error::only('bureau', Fields::except('bureau', $fields));
                $response->assertJson([
                    'status' => 400,
                    'error' => $error,
                ]);
            }
        }
        $this->printSuccessMessage('store bureau; by logging with it team member.');
    }

    private function assertPostResponse($response, $bureau, $user_id){
        $id = Bureau::where('name', $bureau['name'])->first()->id;
        $data = [
            'id' => $id,
            "name" => $bureau['name'],
            "office_number" => $bureau['office_number'],
            "building_number" => $bureau['building_number'],
            "description" => $bureau['description'],
            "user_id" => $user_id,
        ];
        $data = $this->getFullData($data, $bureau);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 201,
            'bureau' => $data,
        ]);
    }

    private function getFullData($data, $bureau) {
        if (array_key_exists('location', $bureau))
            $data['location'] = $bureau['location'];
        if (array_key_exists('accountable_to', $bureau))
            $data['accountable_to'] = $bureau['accountable_to'];
        return $data;
    }

//    public function testShowForAdmin(){
//        $this->actingAs($this->getUser(UserType::getAdmin()));
//        $bureaus = Bureau::orderBy('building_number', 'asc')->limit(30)->get();
//
//        foreach ($bureaus as $bureau){
//            $response = $this->get($this->url . $bureau->id);
//            $this->assertShowForAdminAndItTeamMember($response, $bureau, true);
//        }
//
//        $id = Bureau::orderBy('id', 'desc')->first()->id + 1;
//        $response = $this->get($this->url . $id);
//        $this->assertShowForAdminAndItTeamMember($response);
//        $this->printSuccessMessage('show bureau; by logging with admin');
//    }
//
//    public function testShowForItTeamMember(){
//        $this->actingAs($this->getUser(UserType::getItTeamMember()));
//        $bureaus = Bureau::orderBy('name', 'asc')->limit(30)->get();
//
//        foreach ($bureaus as $bureau){
//            $response = $this->get($this->url . $bureau->id);
//            $this->assertShowForAdminAndItTeamMember($response, $bureau, true);
//        }
//
//        $id = Bureau::orderBy('id', 'desc')->first()->id + 1;
//        $response = $this->get($this->url . $id);
//        $this->assertShowForAdminAndItTeamMember($response);
//        $this->printSuccessMessage('show bureau; by logging with it team member');
//    }
//
//    private function assertShowForAdminAndItTeamMember($response, $bureau=null, $isValid=false){
//        $response->assertStatus(200);
//        if (! $isValid){
//            $response->assertJson([
//                'status' => 400,
//                'error' =>[
//                    'error' => ['Bureau doesn\'t exist.']
//                ]
//            ]);
//        }
//        else{
//            $response->assertJson([
//                'status' => 200,
//                'bureau' =>  [
//                    'id' => $bureau->id,
//                    "name" => $bureau->name,
//                    "description" => $bureau->description,
//                    'user_id' => $bureau->user_id,
//                    'location' => $bureau->location,
//                    'building_number' => $bureau->building_number,
//                    'office_number' => $bureau->office_number,
//                    'accountable_to' => $bureau->accountable_to,
//                ]
//            ]);
//        }
//    }
//
//    public function testDestroyForAdmin(){
//        $this->actingAs($this->getUser(UserType::getAdmin()));
//        $buildings = Bureau::orderBy('name', 'asc')->limit(30)->get();
//
//        foreach ($buildings as $building){
//            $response = $this->delete($this->url . $building->id);
//
//            $response->assertStatus(200);
//            $response->assertJson([
//                'status' => 200,
//            ]);
//        }
//
//        $id = Bureau::orderBy('id', 'desc')->first()->id + 1;
//        $response = $this->delete($this->url . $id);
//        $response->assertStatus(200);
//        $response->assertJson([
//            'status' => 400,
//            'error' =>[
//                'error' => ['Bureau doesn\'t exist.']
//            ]
//        ]);
//
//        $this->restoreDeletedBuildings();
//        $this->printSuccessMessage('destroy bureau by logging with admin');
//    }
//
//    public function testDestroyForItTeamMember(){
//        $this->actingAs($this->getUser(UserType::getItTeamMember()));
//        $bureaus = Bureau::orderBy('name', 'asc')->limit(30)->get();
//
//        foreach ($bureaus as $bureau){
//            $response = $this->delete($this->url . $bureau->id);
//
//            $response->assertStatus(200);
//            $response->assertJson([
//                'status' => 200,
//            ]);
//        }
//
//        $id = Bureau::orderBy('id', 'desc')->first()->id + 1;
//        $response = $this->delete($this->url . $id);
//        $response->assertStatus(200);
//        $response->assertJson([
//            'status' => 400,
//            'error' =>[
//                'error' => ['Bureau doesn\'t exist.']
//            ]
//        ]);
//
//        $this->restoreDeletedBuildings();
//        $this->printSuccessMessage('destroy bureau by logging with admin');
//    }
//
//    private function restoreDeletedBuildings(){
//        Bureau::withTrashed()->restore();
//        $this->printSuccessMessage('all bureaus deleted restored');
//
//    }
}
