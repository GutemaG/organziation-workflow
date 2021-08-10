<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\OnlineRequestStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlineRequestStepTest extends MyTestCase
{

    protected $url = '/api/online-request-steps/';
    protected $modelName = OnlineRequestStep::class;
    protected $defaultTest = false;

    public function testIndex(): void
    {
        $user = $this->getUser(UserType::staff());
        $this->actingAs($user);
        $response = $this->getJson($this->url);
        $response->dump();
//        dump(OnlineRequestStep::all());
    }
}
