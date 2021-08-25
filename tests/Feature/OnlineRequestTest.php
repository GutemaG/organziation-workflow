<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\OnlineRequest;
use App\Models\User;
use App\Utilities\InputFieldType;
use App\Utilities\RequestType;
use Database\Factories\Utility;

class OnlineRequestTest extends MyTestCase
{
    protected string $url = '/api/online-requests';
    protected string $modelName = OnlineRequest::class;
    protected bool $defaultTest = false;
    protected array $with = ['onlineRequestProcedures.users', 'onlineRequestPrerequisiteNotes', 'onlineRequestPrerequisiteInputs'];
/*
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

    protected function formatResponseData(array $onlineRequests): array
    {
        $requestLength = count($onlineRequests);
        for ($i = 0; $i < $requestLength; $i++) {
            $procedureLength = count($onlineRequests[$i]['online_request_procedures']);
            for ($j = 0; $j < $procedureLength; $j++) {
                $usersId = collect($onlineRequests[$i]['online_request_procedures'][$j]['users'])
                    ->map(function ($value) { return $value['id']; })->toArray();
                $onlineRequests[$i]['online_request_procedures'][$j]['responsible_user_id'] = $usersId;
                unset($onlineRequests[$i]['online_request_procedures'][$j]['users']);
            }
        }
        return $onlineRequests;
    }

    protected function index(User $user): void
    {
        $this->actingAs($user);
        $response = $this->getJson($this->url);
        $data = OnlineRequest::with($this->with)->orderBy('name', 'asc')->get()->toArray();
        $data = self::formatResponseData($data);
        $response->assertExactJson([
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
        $this->assertPrerequisites($user);
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
        $url = $update ? "$this->url/1 ": $this->url;
        $this->actingAs($user);
        $response = $update ? $this->putJson($url, []) : $this->postJson($url, []);
        $response->assertExactJson([
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
        $url = $update ? "$this->url/1" : $this->url;
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
        $url = $update ? "$this->url/1" : $this->url;
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
*/
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
            ],
            'prerequisites' => [
                'inputs' => [
                    [
                        'name' => 'test-name',
                        'input_id' => 'test-id',
                        'type' => InputFieldType::random()
                    ],
                ],
                'notes' => ['this is test note'],
            ]
        ]);
        $procedure = OnlineRequest::whereName('new name')->first()->onlineRequestProcedures()->first();
        $this->assertDatabaseHas('online_requests', ['name' => 'new name']);
        $this->assertDatabaseHas('online_request_procedures', ['responsible_bureau_id' => 1, 'step_number' => 1]);
        $this->assertDatabaseHas('online_request_procedure_users', ['procedure_id' => $procedure->id, 'user_id' => 1]);
        $this->assertDatabaseHas('online_request_procedure_users', ['procedure_id' => $procedure->id, 'user_id' => 2]);
        $onlineRequest = OnlineRequest::with($this->with)->orderByDesc('id')->first()->toArray();
        $response->assertExactJson([
            'status' => 201,
            'online_request' => $onlineRequest,
        ]);
    }
/*
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
        $onlineRequest = $this->randomData(OnlineRequest::class, $this->with);
        $response = $this->getJson("$this->url/$onlineRequest->id");
        $response->assertJson([
            'status' => 200,
            'online_request' => $onlineRequest->toArray(),
        ]);
    }
*/
    public function testAdminCanAccessUpdate(): void
    {
        $user = $this->getUser(UserType::admin());
//        $this->majorValidation($user, true);
//        $this->majorNestedValidation($user, true);
//        $this->additionalNestedValidation($user, true);
//        $this->assertPrerequisites($user, true);
        $this->update($user);
        $this->printSuccessMessage('Admin can create new online request procedure passed ');
    }

//    public function testItTeamCanAccessUpdate(): void
//    {
//        $user = $this->getUser(UserType::itTeam());
//        $this->majorValidation($user, true);
//        $this->majorNestedValidation($user, true);
//        $this->additionalNestedValidation($user, true);
//        $this->assertPrerequisites($user, true);
//        $this->update($user);
//        $this->printSuccessMessage('Admin can create new online request procedure passed ');
//    }

    protected function update(User $user): void
    {
        $type = RequestType::getOthers();
        $this->actingAs($user);
        $this->creatingOnlineRequest($user);
        $onlineRequest = OnlineRequest::with($this->with)->orderBy('id', 'DESC')->first();
        $step_number = $onlineRequest->onlineRequestProcedures->last()->step_number;
        $data = $onlineRequest->toArray();
        $data['name'] = 'this is changed name';
        $data['type'] = $type;
        $data['description'] = 'this is changed description';
        $data['online_request_procedures'][0]['responsible_bureau_id'] = 5;
        $data['online_request_procedures'][0]['description'] = 'this is description for procedure';
        $data['online_request_procedures'][0]['responsible_user_id'] = [1, 3, 4, 5, 7];
        $new = ['responsible_bureau_id' => 5, 'responsible_user_id' => [4, 5], 'step_number' => $step_number + 1];
        array_push($data['online_request_procedures'], $new);
        if (array_key_exists('online_request_prerequisite_notes', $data))
            if (!empty($data['online_request_prerequisite_notes'])) {
                $data['online_request_prerequisite_notes'][0]['note'] = 'test for the first not is changed';
                $data['prerequisites'] = ['notes' => $data['online_request_prerequisite_notes']];
                $data['prerequisites']['notes'][] = ['note' => 'this is new note'];
            }
        if (array_key_exists('online_request_prerequisite_inputs', $data))
            if (!empty($data['online_request_prerequisite_inputs'])) {
                $data['online_request_prerequisite_inputs'][0]['name'] = 'changed-name';
                $data['online_request_prerequisite_inputs'][0]['type'] = InputFieldType::random();
                $data['online_request_prerequisite_inputs'][] = [
                    'name' => 'new-name',
                    'input_id' => 'new-id',
                    'type' => InputFieldType::random()
                ];
                if (array_key_exists('prerequisites', $data))
                    $data['prerequisites']['inputs'] = $data['online_request_prerequisite_inputs'];
                else
                    $data['prerequisites'] = ['inputs' => $data['online_request_prerequisite_inputs']];
            }
        $response = $this->putJson("$this->url/$onlineRequest->id", $data);
        $result = OnlineRequest::with($this->with)->orderBy('id', 'DESC')->first()->toArray();
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
/*
    public function testAdminCanAccessDestroy(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->destroy($user);
        $this->printSuccessMessage('Admin can destroy any online request passed ');
    }

    public function testItTeamCanAccessDestroy(): void
    {
        $user = $this->getUser(UserType::itTeam());
        $this->destroy($user);
        $this->printSuccessMessage('It team can destroy any online request passed ');
    }

    protected function destroy(User $user): void
    {
        $this->actingAs($user);
        $onlineRequest = $this->randomData(OnlineRequest::class, $this->with);
        $response = $this->deleteJson("$this->url/$onlineRequest->id");
        $response->assertExactJson([
            'status' => 200,
        ]);
        $this->assertSoftDeleted($onlineRequest);
        foreach ($onlineRequest->onlineRequestProcedures as $procedure) {
            $this->assertSoftDeleted($procedure);
            foreach ($procedure->users as $user)
                $this->assertSoftDeleted($user);
        }
        foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input)
            $this->assertSoftDeleted($input);
        foreach ($onlineRequest->onlineRequestPrerequisiteNotes as $note)
            $this->assertSoftDeleted($note);
    }

    private function assertPrerequisites(User $user, bool $update=false): void
    {
        $this->actingAs($user);
        $url = $update ? "$this->url/1" : $this->url;
        $data = [
            'name' => 'new name',
            'type' => Utility::getRandomRequestType(),
            'description' => 'this is description',
            'online_request_procedures' => [
                [
                    'responsible_bureau_id' => 1,
                    'responsible_user_id' => [1, 2],
                    'step_number' => 1
                ]
            ],
            'prerequisites' => [],
        ];
        $response = $update ? $this->putJson($url, $data) : $this->postJson($url, $data);
        $response->assertExactJson(['status' => 422, 'error' => ['prerequisites' => ["The prerequisites must have at least 1 items."]]]);

        $data = [
            'name' => 'new name',
            'type' => Utility::getRandomRequestType(),
            'description' => 'this is description',
            'online_request_procedures' => [
                [
                    'responsible_bureau_id' => 1,
                    'responsible_user_id' => [1, 2],
                    'step_number' => 1
                ]
            ],
            'prerequisites' => ['notes' => [], 'inputs' => []],
        ];
        $response = $update ? $this->putJson($url, $data) : $this->postJson($url, $data);
        $response->assertExactJson([
            'status' => 422,
            'error' => ['prerequisites.inputs' => ['The prerequisites.inputs must have at least 1 items.'],
                'prerequisites.notes' => ['The prerequisites.notes must have at least 1 items.']]
        ]);

        $data = [
            'name' => 'new name',
            'type' => Utility::getRandomRequestType(),
            'description' => 'this is description',
            'online_request_procedures' => [
                [
                    'responsible_bureau_id' => 1,
                    'responsible_user_id' => [1, 2],
                    'step_number' => 1
                ]
            ],
            'prerequisites' => ['notes' => ['jdkf'], 'inputs' => ['kdjfk']],
        ];
        $response = $update ? $this->putJson($url, $data) : $this->postJson($url, $data);
        $update ? $response->assertExactJson([
                    'status' => 422,
                    'error' => [
                        "prerequisites.inputs.0.name" => ['The prerequisites.inputs.0.name field is required.'],
                        "prerequisites.inputs.0.input_id" => ['The prerequisites.inputs.0.input_id field is required.'],
                        "prerequisites.inputs.0.type" => ['The prerequisites.inputs.0.type field is required.'],
                        "prerequisites.notes.0" => ['The prerequisites.notes.0 must be an array.'],
                        'prerequisites.notes.0.note' => ['The prerequisites.notes.0.note field is required.']
                    ]
                ])
            : $response->assertExactJson([
                'status' => 422,
                'error' => [
                    "prerequisites.inputs.0.name" => ['The prerequisites.inputs.0.name field is required.'],
                    "prerequisites.inputs.0.input_id" => ['The prerequisites.inputs.0.input_id field is required.'],
                    "prerequisites.inputs.0.type" => ['The prerequisites.inputs.0.type field is required.'],
                ]
        ]);
    }
*/
}
