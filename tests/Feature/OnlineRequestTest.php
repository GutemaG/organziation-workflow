<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\OnlineRequest;
use App\Models\User;
use App\Utilities\RequestType;
use Database\Factories\Utility;

class OnlineRequestTest extends MyTestCase
{
    protected $url = '/api/online-requests/';
    protected $modelName = OnlineRequest::class;

    public function testAdminCanAccessIndex(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->index($user);
        $this->printSuccessMessage('Admin can access index passed ');
    }

    public function testItTeamCanAccessIndex(): void
    {
        $user = $this->getUser(UserType::itTeam());
        $this->index($user);
        $this->printSuccessMessage('It team can access index passed ');
    }

    protected function index(User $user): void
    {
        $this->actingAs($user);
        $response = $this->getJson($this->url);
        $data = OnlineRequest::orderBy('name', 'asc')->get()->toArray();
        $response->assertJson([
            'status' => 200,
            'online_requests' => $data,
        ]);
    }

    public function testAdminCanAccessPost(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->majorValidation($user);
        $this->majorNestedValidation($user);
        $this->additionalNestedValidation($user);
        $this->creatingOnlineRequest($user);
        $this->printSuccessMessage('Admin can create new online request procedure passed ');
    }

    public function testItTeamCanAccessPost(): void
    {
        $user = $this->getUser(UserType::itTeam());
        $this->majorValidation($user);
        $this->majorNestedValidation($user);
        $this->additionalNestedValidation($user);
        $this->creatingOnlineRequest($user);
        $this->printSuccessMessage('It team can create new online request procedure passed ');
    }

    protected function majorValidation(User $user, bool $update=false): void
    {
        $url = $update ? $this->url . 1 : $this->url;
        $this->actingAs($user);
        $response = $update ? $this->putJson($url, []) : $this->postJson($url, []);
        $response->assertJson([
            'status' => 422,
            'error' => [
                'type' => ['The type field is required.'],
                'name' => ['The name field is required.'],
                'description' => ['The description field is required.'],
                'online_request_procedures' => ['The online request procedures field is required.'],
            ]
        ]);
    }

    protected function majorNestedValidation(User $user, bool $update=false): void
    {
        $url = $update ? $this->url . 1 : $this->url;
        $this->actingAs($user);
        $data = ['name' => 'new name', 'type' => Utility::getRandomRequestType(), 'description' => 'this is description', 'online_request_procedures' => 'test',];
        $response = $update ? $this->putJson($url, $data) : $this->postJson($url, $data);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'online_request_procedures' => ["The online request procedures must be an array."],
            ]
        ]);

        $data = ['name' => 'new name', 'type' => Utility::getRandomRequestType(), 'description' => 'this is description', 'online_request_procedures' => [[]]];
        $response = $update ? $this->putJson($url, $data) : $this->postJson($url, $data);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'online_request_procedures.0.responsible_bureau_id' => ['The online_request_procedures.0.responsible_bureau_id field is required.'],
                'online_request_procedures.0.responsible_user_id' => ['The online_request_procedures.0.responsible_user_id field is required.'],
                'online_request_procedures.0.step_number' => ['The online_request_procedures.0.step_number field is required.'],
            ]
        ]);
    }

    protected function additionalNestedValidation(User $user, bool $update=false): void
    {
        $url = $update ? $this->url . 1 : $this->url;
        $this->actingAs($user);
        $data = ['name' => 'new name', 'type' => Utility::getRandomRequestType(), 'description' => 'this is description', 'online_request_procedures' => [
                        ['responsible_bureau_id' => 876, 'responsible_user_id' => [487549], 'step_number' => 6]
                ]
        ];
        $response = $update ? $this->putJson($url, $data) : $this->postJson($url, $data);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                "online_request_procedures.0.responsible_bureau_id" => ["The selected online_request_procedures.0.responsible_bureau_id is invalid."],
                "online_request_procedures.0.responsible_user_id.0" => ["The selected online_request_procedures.0.responsible_user_id.0 is invalid."],
                "online_request_procedures.0.step_number" => ["step_number should be 1. Or please enter the step number in incremental order."],
            ]
        ]);
    }

    protected function creatingOnlineRequest(User $user): void
    {
        $this->actingAs($user);
        $response = $this->postJson($this->url, [
            'name' => 'new name',
            'type' => Utility::getRandomRequestType(),
            'description' => 'this is description',
            'online_request_procedures' => [
                [
                    'responsible_bureau_id' => 1,
                    'responsible_user_id' => [1, 2],
                    'step_number' => 1
                ]
            ]
        ]);
        $procedure = OnlineRequest::whereName('new name')->first()->onlineRequestProcedures()->first();
        $this->assertDatabaseHas('online_requests', ['name' => 'new name']);
        $this->assertDatabaseHas('online_request_procedures', ['responsible_bureau_id' => 1, 'step_number' => 1]);
        $this->assertDatabaseHas('online_request_procedure_users', ['procedure_id' => $procedure->id, 'user_id' => 1]);
        $this->assertDatabaseHas('online_request_procedure_users', ['procedure_id' => $procedure->id, 'user_id' => 2]);
    }

    public function testAdminCanAccessShow(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->show($user);
        $this->printSuccessMessage('Admin can view any online request passed ');
    }

    public function testItTeamCanAccessShow(): void
    {
        $user = $this->getUser(UserType::itTeam());
        $this->show($user);
        $this->printSuccessMessage('It team can view any online request passed ');
    }

    protected function show(User $user): void
    {
        $this->actingAs($user);
        $onlineRequest = $this->randomData(OnlineRequest::class);
        $response = $this->getJson($this->url . $onlineRequest->id);
        $response->assertJson([
            'status' => 200,
            'online_request' => $onlineRequest->toArray(),
        ]);
    }

    public function testAdminCanAccessUpdate(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->majorValidation($user, true);
        $this->majorNestedValidation($user, true);
        $this->additionalNestedValidation($user, true);
        $this->update($user);
        $this->printSuccessMessage('Admin can create new online request procedure passed ');
    }

    public function testItTeamCanAccessUpdate(): void
    {
        $user = $this->getUser(UserType::itTeam());
        $this->majorValidation($user, true);
        $this->majorNestedValidation($user, true);
        $this->additionalNestedValidation($user, true);
        $this->update($user);
        $this->printSuccessMessage('Admin can create new online request procedure passed ');
    }

    protected function update(User $user): void
    {
        $type = RequestType::getOthers();
        $this->actingAs($user);
        $this->creatingOnlineRequest($user);
        $onlineRequest = OnlineRequest::orderBy('id', 'DESC')->first();
        $data = $onlineRequest->toArray();
        $data['name'] = 'this is changed name';
        $data['type'] = $type;
        $data['description'] = 'this is changed description';
        $data['online_request_procedures'][0]['responsible_bureau_id'] = 5;
        $data['online_request_procedures'][0]['description'] = 'this is description for procedure';
        $data['online_request_procedures'][0]['responsible_user_id'] = [1, 3, 4, 5, 7];
        array_pop($data);
        $response = $this->putJson($this->url . $onlineRequest->id, $data);
        $result = OnlineRequest::orderBy('id', 'DESC')->first()->toArray();
        $result['name'] = 'this is changed name';
        $result['type'] = $type;
        $result['description'] = 'this is changed description';
        $result['online_request_procedures'][0]['responsible_bureau_id'] = '5';
        $result['online_request_procedures'][0]['description'] = 'this is description for procedure';
        $result['online_request_procedures'][0]['users'][0]['id'] = 1;
        $result['online_request_procedures'][0]['users'][1]['id'] = 3;
        $result['online_request_procedures'][0]['users'][2]['id'] = 4;
        $result['online_request_procedures'][0]['users'][3]['id'] = 5;
        $result['online_request_procedures'][0]['users'][4]['id'] = 7;

        $response->assertExactJson([
            'status' => 200,
            'online_request' => $result,
        ]);
    }

    public function testAdminCanAccessDestroy(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->destroy($user);
        $this->printSuccessMessage('Admin can destroy any online request passed ');
    }

    public function testItTeamCanAccessDestroy(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->destroy($user);
        $this->printSuccessMessage('It team can destroy any online request passed ');
    }

    protected function destroy(User $user): void
    {
        $this->actingAs($user);
        $onlineRequest = $this->randomData(OnlineRequest::class);
        $response = $this->deleteJson($this->url . $onlineRequest->id);
        $response->assertExactJson([
            'status' => 200,
        ]);
        $this->assertSoftDeleted($onlineRequest);
        OnlineRequest::withTrashed()->restore();
    }
}
