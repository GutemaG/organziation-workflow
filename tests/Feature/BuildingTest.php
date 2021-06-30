<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\UserType;
use App\Models\Building;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Utilities\FakeDataGenerator;
use Tests\Feature\Utilities\Utility;
use Tests\TestCase;

class BuildingTest extends TestCase
{
    private function printSuccessMessage($message){
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n</info>");
        print_r("<info>  $message --- success.  \n</info>");
        print_r("<info>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n\n\n</info>");
    }

    public function testUnauthenticatedUserCanAccess(){
        $response = $this->get('/api/buildings');
        $this->checkResponseOfUnauthenticatedUser($response);
        $response = $this->get('/api/buildings');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/buildings');
        $this->checkResponseOfUnauthenticatedUser($response);

        $response = $this->get('/api/buildings');
        $this->checkResponseOfUnauthenticatedUser($response);
        $this->printSuccessMessage('unauthenticated user can access buildings or store buildings');
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
        $response = $this->get('/api/buildings');
        $this->assertUnauthorizedUser($response);

        $response = $this->post('/api/users/', ['number' => 4785]);
        $this->assertUnauthorizedUser($response);

        for ($i = 0; $i < 10; $i++){
            $buildings = Building::orderBy('number', 'asc')->limit(10);
            foreach ($buildings as $building){
                $response = $this->get('/api/buildings/' . $building->id);
                $this->assertUnauthorizedUser($response);

                $response = $this->put('/api/buildings/' . $building->id, ['number' => 454]);
                $this->assertUnauthorizedUser($response);

                $response = $this->delete('/api/buildings/' . $building->id);
                $this->assertUnauthorizedUser($response);
            }
        }
    }

    public function testStaffCanAccessUsers(){
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getStaff());
        $this->printSuccessMessage('authenticated staff can access any buildings or can store buildings');

    }

    public function testReceptionCanAccessUsers(){
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::getReception());
        $this->printSuccessMessage('authenticated reception can access any buildings or can store buildings');
    }

    public function testIndex(){
        $this->indexForAdminAndItTeamMember(UserType::getAdmin());
        $this->printSuccessMessage('list all buildings; by logging with admin');

        $this->indexForAdminAndItTeamMember(UserType::getItTeamMember());
        $this->printSuccessMessage('list all buildings; by logging with it team member');
    }

    private function indexForAdminAndItTeamMember($type){
        $this->actingAs($this->getUser($type));
        $response = $this->get('/api/buildings/');
        $buildings = Building::orderBy('number', 'asc')->get();
        $length = $buildings->count();
        $building = $buildings->first();
        $response->assertJson(fn (AssertableJson $json) =>
        $json->has('status')
            ->has('buildings', $length, fn ($json) =>
            $json->where('id', $building->id)
                ->where('number', $building->number)
                ->where('number_of_offices', $building->number_of_offices)
                ->has('created_at')
                ->missing('updated_at')
                ->missing('deleted_at')
            )
        );
    }

    public function testPostForAdmin(){
        $this->actingAs($this->getUser(UserType::getAdmin()));

        $building = FakeDataGenerator::buildingData();
        $response = $this->post('/api/buildings', $building);
        $this->assertPostResponse($response, $building);


        foreach (Utility::allCombinationOfBuildingData() as $fields) {
            $building = FakeDataGenerator::buildingDataOnly($fields);
            $response = $this->post('/api/buildings', $building);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(Fields::building())) {
                $this->assertPostResponse($response, $building);
            } elseif (collect($fieldsMap)->has('number')) {
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices field is required.']
                    ],
                ]);
            } elseif (collect($fieldsMap)->has('number_of_offices')) {
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number' => ['The number field is required.']
                    ],
                ]);
            } else{
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices field is required.'],
                        'number' => ['The number field is required.']
                    ],
                ]);
            }
        }
        $this->printSuccessMessage('store building; by logging with admin');
    }

    private function assertPostResponse($response, $building=null){

        $id = Building::where('number', $building['number'])->first()->id;
        $data = [
            'id' => $id,
            "number" => $building['number'],
            "number_of_offices" => $building['number_of_offices'],
        ];

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 201,
            'building' => $data,
        ]);
    }

    public function testPostForItTeamMember(){
        $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $building = FakeDataGenerator::buildingData();
        $response = $this->post('/api/buildings', $building);
        $this->assertPostResponse($response, $building);


        foreach (Utility::allCombinationOfBuildingData() as $fields) {
            $building = FakeDataGenerator::buildingDataOnly($fields);
            $response = $this->post('/api/buildings', $building);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(Fields::building())) {
                $this->assertPostResponse($response, $building);
            } elseif (collect($fieldsMap)->has('number')) {
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices field is required.']
                    ],
                ]);
            } elseif (collect($fieldsMap)->has('number_of_offices')) {
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number' => ['The number field is required.']
                    ],
                ]);
            } else{
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices field is required.'],
                        'number' => ['The number field is required.']
                    ],
                ]);
            }
        }
        $this->printSuccessMessage('store building; by logging with it team member');
    }

    public function testShowForAdmin(){
        $this->actingAs($this->getUser(UserType::getAdmin()));
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(30)->get();

        foreach ($buildings as $building){
            $response = $this->get('/api/buildings/' . $building->id);
            $this->assertShowForAdminAndItTeamMember($response, $building, true);
        }

        $id = Building::orderBy('id', 'desc')->first()->id + 1;
        $response = $this->get('/api/buildings/' . $id);
        $this->assertShowForAdminAndItTeamMember($response);
        $this->printSuccessMessage('show building; by logging with admin');
    }

    public function testShowForItTeamMember(){
        $this->actingAs($this->getUser(UserType::getItTeamMember()));
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(30)->get();

        foreach ($buildings as $building){
            $response = $this->get('/api/buildings/' . $building->id);
            $this->assertShowForAdminAndItTeamMember($response, $building, true);
        }

        $id = Building::orderBy('id', 'desc')->first()->id + 1;
        $response = $this->get('/api/buildings/' . $id);
        $this->assertShowForAdminAndItTeamMember($response);
        $this->printSuccessMessage('show building; by logging with it team member');
    }

    private function assertShowForAdminAndItTeamMember($response, $building=null, $isValid=false){
        $response->assertStatus(200);
        if (! $isValid){
            $response->assertJson([
                'status' => 400,
                'error' =>[
                    'error' => ['Building doesn\'t exist.']
                ]
            ]);
        }
        else{
            $response->assertJson([
                'status' => 200,
                'building' =>  [
                    'id' => $building->id,
                    "number" => $building->number,
                    "number_of_offices" => $building->number_of_offices,
                ]
            ]);
        }
    }

    public function testUpdateForAdminWithInvalidValue1(){
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateWithInvalidNumberAndNumberOfOffices($building, UserType::getAdmin());
            $this->updateWithInvalidNumber($building, UserType::getAdmin());
        }
        $this->printSuccessMessage('update building with invalid fields and values phase 1; by logging with admin');
    }

    public function testUpdateForAdminWithInvalidValue2(){
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateWithInvalidNumberOfOffices($building, UserType::getAdmin());
        }
        $this->printSuccessMessage('update building with invalid fields and values phase 2; by logging with admin');
    }

    public function testUpdateForAdminWithValidValue(){
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateValidFieldsAndValues($building, UserType::getAdmin());
        }
        $this->printSuccessMessage('update building with valid fields and values; by logging with admin');
    }

    public function testUpdateForItTeamMemberWithInvalidValue1(){
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateWithInvalidNumberAndNumberOfOffices($building, UserType::getItTeamMember());
            $this->updateWithInvalidNumber($building, UserType::getAdmin());
        }
        $this->printSuccessMessage('update building with invalid fields and values phase 1; by logging with it team member');
    }

    public function testUpdateForItTeamMemberWithInvalidValue2(){
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateWithInvalidNumberOfOffices($building, UserType::getItTeamMember());
        }
        $this->printSuccessMessage('update building with invalid fields and values phase 2; by logging with it team member');
    }

    public function testUpdateForItTeamMemberWithValidValue(){
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateValidFieldsAndValues($building, UserType::getItTeamMember());
        }
        $this->printSuccessMessage('update building with valid fields and values; by logging with it team member');
    }

    private function updateValidFieldsAndValues($building, $type){
        if($type == UserType::getAdmin())
            $this->actingAs($this->getUser(UserType::getAdmin()));
        else
            $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $data = FakeDataGenerator::buildingData();

        $response = $this->put('/api/buildings/' . $building->id, $data);
        $building->number = $data['number'];
        $building->number_of_offices = $data['number_of_offices'];
        $this->assertUpdate(6, $response, null, null, $building);
    }

    private function updateWithInvalidNumberAndNumberOfOffices($building, $type){
        if($type == UserType::getAdmin())
            $this->actingAs($this->getUser(UserType::getAdmin()));
        else
            $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $response = $this->put('/api/buildings/' . $building->id, ['number' => '', 'number_of_offices' => '']);
        $this->assertUpdate(5, $response);

    }

    private function updateWithInvalidNumber(Building $building, $type){
        if($type == UserType::getAdmin())
            $this->actingAs($this->getUser(UserType::getAdmin()));
        else
            $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $response = $this->put('/api/buildings/' . $building->id, ['number' => '']);
        $this->assertUpdate(2, $response);
    }

    private function updateWithInvalidNumberOfOffices(Building $building, $type){
        if($type == UserType::getAdmin())
            $this->actingAs($this->getUser(UserType::getAdmin()));
        else
            $this->actingAs($this->getUser(UserType::getItTeamMember()));

        $response = $this->put('/api/buildings/' . $building->id, ['number_of_offices' => 'test']);
        $this->assertUpdate(4, $response);

        $response = $this->put('/api/buildings/' . $building->id, ['number_of_offices' => '']);
        $this->assertUpdate(3, $response);

    }

    private function assertUpdate($case, $response, $key=null, $value=null, $building=null){
        switch ($case){
            case 1:
                $response->assertJson( [
                    'status' => 400,
                    'error' =>[
                        'error' => ['Building doesn\'t exist.']
                    ],
                ]);
                break;
            case 2:
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number' => ['The number field is required.']
                    ],
                ]);
                break;
            case 3:
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices field is required.']
                    ],
                ]);
                break;
            case 4:
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices must be an integer.']
                    ],
                ]);
                break;
            case 5:
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices field is required.'],
                        'number' => ['The number field is required.']
                    ],
                ]);
                break;
            case 6:
                $user = $this->changeUserValue($key, $value, $building);
                $response->assertJson( [
                    'status' => 200,
                    'building' => [
                        'id' => $building->id,
                        "number" => $building->number,
                        "number_of_offices" => $building->number_of_offices,
                    ],
                ]);
                return $user;
        }
    }

    private function changeUserValue($attribute, $value, $building){
        switch ($attribute){
            case 'number':
                $building->number = $value;
                break;
            case 'number_of_offices':
                $building->number_of_offices = $value;
                break;
//            case 'last_name':
//                $user->last_name = $value;
//                break;
//            case 'email':
//                $user->email = $value;
//                break;
//            case 'phone':
//                $user->phone = $value;
//                break;
//            case 'type':
//                $user->type = $value;
//                break;
        }
        return $building;
    }

    public function testDestroyForAdmin(){
        $this->actingAs($this->getUser(UserType::getAdmin()));
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(30)->get();

        foreach ($buildings as $building){
            $response = $this->delete('/api/buildings/' . $building->id);

            $response->assertStatus(200);
            $response->assertJson([
                'status' => 200,
            ]);
        }

        $id = Building::orderBy('id', 'desc')->first()->id + 1;
        $response = $this->delete('/api/buildings/' . $id);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'error' =>[
                'error' => ['Building doesn\'t exist.']
            ]
        ]);

        $this->restoreDeletedBuildings();
        $this->printSuccessMessage('destroy buildings by logging with admin');
    }

    public function testDestroyForItTeamMember(){
        $this->actingAs($this->getUser(UserType::getItTeamMember()));
        $buildings = Building::orderBy('number_of_offices', 'asc')->limit(30)->get();

        foreach ($buildings as $building){
            $response = $this->delete('/api/buildings/' . $building->id);

            $response->assertStatus(200);
            $response->assertJson([
                'status' => 200,
            ]);
        }

        $id = Building::orderBy('id', 'desc')->first()->id + 1;
        $response = $this->delete('/api/buildings/' . $id);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 400,
            'error' =>[
                'error' => ['Building doesn\'t exist.']
            ]
        ]);

        $this->restoreDeletedBuildings();
        $this->printSuccessMessage('destroy buildings by logging with admin');
    }

    private function restoreDeletedBuildings(){
        Building::withTrashed()->restore();
        $this->printSuccessMessage('all building deleted restored');

    }
}
