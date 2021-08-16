<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\NotificationTracker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotificationTrackerTest extends MyTestCase
{
    protected $url = '/api/online-request-applied/';
    protected $modelName = NotificationTracker::class;
    protected $defaultTest = false;

    public function testReject(): void
    {
        $user = User::find(56);
        $this->testRejectWithOutReason($user);
        $this->testRejectWithReason($user);
    }

    private function testRejectWithOutReason(User $user): void
    {
        $this->actingAs($user);
        $response = $this->putJson($this->url . 'reject/17', []);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'reason' => ['The reason field is required.'],
            ]
        ]);
        $this->printSuccessMessage('request without reason rejected ');
    }

    private function testRejectWithReason(User $user): void
    {
        $this->actingAs($user);
        $response = $this->putJson($this->url . 'reject/17', ['reason' => 'this is test reason']);
        $response->assertExactJson([
            'status' => 200,
            'message' => 'Request rejected successfully.',
        ]);
        $this->printSuccessMessage('request without reason rejected ');
    }
}
