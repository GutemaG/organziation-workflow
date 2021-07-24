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
        $response = $this->putJson($this->url . 3 ,[
            'name' => 'changed 3',
            'id' => 3,
            'test'=>'test',
            'description' => 'description changed.',
            'online_request_procedures' => [
                    [
                        'text' => 'text',
                        'test' => 'text',
                        'responsible_bureau_id' => 25,
                        'step_number' => 1,
                        'id' => 13,
                        'responsible_user_id' => [
                            76,
                            64
                        ],
                    ],
                ],
                'prerequisite_labels' => [
                    [
                        'id' => 65,
                        'label' => 'this is test for label.',
                    ],
                    [
                        'label' => 'this is test for label.',
                    ],
                    [
                        'id' => 6,
                        'label' => 'this is test for label.',
                    ],
                    [
                        'label' => 'this is test for label.',
                    ]
                ]
            ]);
//        $response = $this->getJson($this->url . 3);
        $response->dump();

//        $response = $this->postJson($this->url ,[
//            'name' => 'this is name 3',
//            'description' => 'this is description.',
//            'online_request_procedures' => [
//                [
//                    'responsible_bureau_id' => 25,
//                    'step_number' => 1,
//                    'responsible_user_id' => [
//                        76,
//                        64
//                    ],
//                ],
//                [
//                    'responsible_bureau_id' => 25,
//                    'step_number' => 3,
//                    'responsible_user_id' => [
//                        76,
//                        64
//                    ],
//                ],
//                [
//                    'responsible_bureau_id' => 25,
//                    'step_number' => 2,
//                    'responsible_user_id' => [
//                        76,
//                        64
//                    ],
//                ],
//            ],
//            'prerequisite_labels' => [
//                'label 1',
//                'label 2',
//                'label 3',
//            ]
//        ]);
//        $response->dump();
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
