<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlinePrerequisiteTest extends TestCase
{
    private $url = '/api/online-prerequisites/';

    public function test(){
        $this->actingAs(User::find(1));
        $response = $this->put($this->url . 3);
        $response->assertStatus(200);
        $response->assertJson([
            "status" => 422,
        "error" => [
            "label" => [
                "The label field is required."
            ]
  ]

        ]);
         $response = $this->putJson($this->url . 3, [
             'label' => 'label changed!',
         ]);
         $response->assertJson([
             'status' => 200,
             "prerequisite" => [
                "id" => 3,
                "online_request_id" => 1,
                "label" => "label changed!",
                "created_at" => "2021-07-06T15:58:21.000000Z",
            ]

         ]);
    }
}
