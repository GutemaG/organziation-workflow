<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\OnlineRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlineRequestTest extends TestCase
{
    private $url = '/api/online-requests/';
    public function testUpdate() {
//        $this->unauthorizedUserRequest(UserType::staff());
//        $this->unauthorizedUserRequest(UserType::reception());

        $user = User::where('type', UserType::itTeam())->inRandomOrder()->first();
        $this->actingAs($user);
//        $response = $this->postJson($this->url ,[
//            'name' => 'ddoloresreprehenderitmagniaquis',
//            'id' => 3,
//            'test'=>'test',
//            'description' => 'description changed.',
//            'online_request_procedures' => [
//                    [
//                        'text' => 'text',
//                        'test' => 'text',
//                        'responsible_bureau_id' => 25,
//                        'step_number' => 7,
//                        'id' => 13,
//                        'responsible_user_id' => [
//                            76,
//                            64
//                        ],
//                    ],
//                ],
//                'prerequisite_labels' => [
//                    'this is test for label.',
//                ]
//            ]);
//        $response->dump();

        $response = $this->postJson($this->url ,[
            'name' => 'ddoloresreprehenderitmagniaquis',
            'description' => 'description changed.',
            'online_request_procedures' => [
                [
                    'responsible_bureau_id' => 25,
                    'step_number' => 'r',
                    'responsible_user_id' => [
                        76,
                        64
                    ],
                ],
                [
                    'responsible_bureau_id' => 25,
//                    'step_number' => 3,
                    'responsible_user_id' => [
                        76,
                        64
                    ],
                ],
                [
                    'responsible_bureau_id' => 25,
//                    'step_number' => 9,
                    'responsible_user_id' => [
                        76,
                        64
                    ],
                ],
            ],
        ]);
        $response->dump();
    }

    private function unauthorizedUserRequest($userType) {
        $requestId = OnlineRequest::inRandomOrder()->limit(1)->first()->id;
        $user = User::where('type', $userType)->inRandomOrder()->first();
        $this->actingAs($user);
        $response = $this->putJson($this->url . $requestId ,[]);
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }
}
