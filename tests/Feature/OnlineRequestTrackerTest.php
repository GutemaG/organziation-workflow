<?php

namespace Tests\Feature;

use App\Models\OnlineRequestTracker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlineRequestTrackerTest extends MyTestCase
{
    protected $url = '/api/apply-request/';
    protected $modelName = OnlineRequestTracker::class;
    protected $defaultTest = false;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->postJson($this->url, ['online_request_id' => 2, 'phone_number' => '+251953960596']);
        $response->dump();

        $response->assertStatus(200);
    }
}
