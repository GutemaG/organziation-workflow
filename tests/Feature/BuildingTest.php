<?php
namespace Tests\Feature;

use App\Http\Controllers\Utilities\Fields;
use App\Http\Controllers\Utilities\UserType;
use App\Models\Building;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Utilities\Error;
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
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::staff());
        $this->printSuccessMessage('authenticated staff can access any buildings or can store buildings');

    }

    public function testReceptionCanAccessUsers(){
        $this->assertAllUrlsForStaffAndReceptionUsers(UserType::reception());
        $this->printSuccessMessage('authenticated reception can access any buildings or can store buildings');
    }

    public function testIndex(){
        $this->indexForAdminAndItTeamMember(UserType::admin());
        $this->printSuccessMessage('list all buildings; by logging with admin');

        $this->indexForAdminAndItTeamMember(UserType::itTeam());
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
                ->where('name', $building->name)
                ->where('description', $building->description)
                ->where('number_of_offices', $building->number_of_offices)
                ->has('created_at')
                ->missing('updated_at')
                ->missing('deleted_at')
            )
        );
    }

    public function testPostForAdmin(){
        $this->store(UserType::admin());
        $this->printSuccessMessage('store building; by logging with admin');
    }

    public function testPostForItTeamMember(){
        $this->store(UserType::itTeam());
        $this->printSuccessMessage('store building; by logging with it team member');
    }

    private function store($userType) {
        if ($userType == UserType::admin())
            $this->actingAs($this->getUser(UserType::admin()));
        else
            $this->actingAs($this->getUser(UserType::itTeam()));

        $building = FakeDataGenerator::buildingData();
        $response = $this->post('/api/buildings', $building);
        $this->assertPostResponse($response, $building);

        foreach (Fields::allCombinationOfFields(Building::class) as $fields) {
            $building = FakeDataGenerator::buildingDataOnly($fields);
            $response = $this->post('/api/buildings', $building);
            $fieldsMap = collect($fields)->map(function ($item, $key) {
                return [$item => $item];
            })->collapse();

            if (collect($fieldsMap)->has(['number', 'number_of_offices'])) {
                $this->assertPostResponse($response, $building);
            }
            else {
                $response->assertJson([
                    'status' => 400,
                    'error' => Error::except('building', $fields),
                ]);
            }
        }
        $data = Building::where('name', '!=', null)->inRandomOrder()->first();
        $building = FakeDataGenerator::buildingData();
        $building['name'] = $data['name'];
        $building['number'] = $data['number'];
        $response = $this->post('/api/buildings', $building);
        $response->assertJson([
            'status' => 400,
            'error' => [
                'name' => ["The name has already been taken."],
                'number' => ['The number has already been taken.'],
            ]
        ]);
    }

    private function assertPostResponse($response, $building=null){
        $id = Building::where('number', $building['number'])->first()->id;
        $data = [
            'id' => $id,
            "number" => $building['number'],
            "number_of_offices" => $building['number_of_offices'],
        ];
        array_key_exists('name', $building) ? $data['name'] = $building['name'] : null;
        array_key_exists('description', $building) ? $data['description'] = $building['description'] : null;

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 201,
            'building' => $data,
        ]);
    }

    public function testShowForAdmin(){
        $this->actingAs($this->getUser(UserType::admin()));
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
        $this->actingAs($this->getUser(UserType::itTeam()));
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
                    'name' => $building->name,
                    'description' => $building->description,
                ]
            ]);
        }
    }

    public function testUpdateForAdmin(){
        $buildings = Building::inRandomOrder()->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateWithInvalidValues($building, UserType::admin());
            $this->updateWithValidValues($building, UserType::admin());
        }
        $this->printSuccessMessage('update building with invalid  and valid values; by logging with admin');
    }

    public function testUpdateForItTeamMember(){
        $buildings = Building::inRandomOrder()->limit(20)->get();

        foreach ($buildings as $building){
            $this->updateWithInvalidValues($building, UserType::itTeam());
            $this->updateWithValidValues($building, UserType::itTeam());
        }
        $this->printSuccessMessage('update building with invalid  and valid values; by logging with it team member');
    }


    private function updateWithValidValues($building, $type){
        if($type == UserType::admin())
            $this->actingAs($this->getUser(UserType::admin()));
        else
            $this->actingAs($this->getUser(UserType::itTeam()));

        $data = FakeDataGenerator::buildingData();

        $response = $this->put('/api/buildings/' . $building->id, $data);
        $building->number = $data['number'];
        $building->number_of_offices = $data['number_of_offices'];
        $building->name = $data['name'];
        $building->description = $data['description'];
        $this->assertUpdate(5, $response, $building);
    }

    private function updateWithInvalidValues($building, $type){
        if($type == UserType::admin())
            $this->actingAs($this->getUser(UserType::admin()));
        else
            $this->actingAs($this->getUser(UserType::itTeam()));

        $response = $this->put('/api/buildings/' . $building->id, ['number' => '', 'number_of_offices' => '']);
        $this->assertUpdate(2, $response);

        $response = $this->put('/api/buildings/' . $building->id, ['number_of_offices' => 'test']);
        $this->assertUpdate(3, $response);

        $data = Building::where('name', '!=', null)->inRandomOrder()->first();
        $response = $this->put('/api/buildings/' . $building->id, ['name' => $data->name, 'number' => $data->number]);
        $this->assertUpdate(4, $response);

        $id =  Building::orderBy('id', 'desc')->first()->id + rand(1, 50);
        $response = $this->put('/api/buildings/' . $id, ['name' => null, 'number' => null]);
        $this->assertUpdate(1, $response);

    }

    private function assertUpdate($case, $response, $building=null){
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
                        'number_of_offices' => ['The number of offices field is required.'],
                        'number' => ['The number field is required.']
                    ],
                ]);
                break;
            case 3:
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'number_of_offices' => ['The number of offices must be an integer.']
                    ],
                ]);
                break;
            case 4:
                $response->assertJson([
                    'status' => 400,
                    'error' => [
                        'name' => ['The name has already been taken.'],
                        'number' => ["The number has already been taken."],
                    ],
                ]);
                break;
            case 5:
                $response->assertJson( [
                    'status' => 200,
                    'building' => [
                        'id' => $building->id,
                        "number" => $building->number,
                        "number_of_offices" => $building->number_of_offices,
                        "name" => $building->name,
                        "description" => $building->description,
                    ],
                ]);
        }
    }

    public function testDestroyForAdmin(){
        $this->actingAs($this->getUser(UserType::admin()));
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
        $this->actingAs($this->getUser(UserType::itTeam()));
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
