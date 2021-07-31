<?php

namespace Tests\Feature;

use App\Models\OnlineRequestProcedure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlineRequestProcedureTest extends TestCase
{
    private $url = '/api/online-procedures/';

    public function test() {
        $this->actingAs(User::find(1));
        $response = $this->putJson($this->url . 3, []);
        $response->assertJson([
            "status" => 422,
            "error" => [
                "online_request_id" => [
                    "The online request id field is required.",
                ],
                "responsible_bureau_id" => [
                    "The responsible bureau id field is required.",
                ],
                "step_number" => [
                    "The step number field is required.",
                ],
            ]
        ]);

        $response = $this->putJson($this->url . 3, [
            'responsible_bureau_id' => 140,
            'online_request_id' => 1,
            'description' => 'new description',
            'step_number' => 3,
            'responsible_user_id' => [
                1,2,3,
            ]
        ]);

        $response = $this->deleteJson($this->url . 3);
        $response->dump();
        OnlineRequestProcedure::withTrashed()->where('id', 3)->restore();

    }
}
