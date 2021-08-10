<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\OnlineRequestStep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OnlineRequestStepTest extends MyTestCase
{

    protected $url = '/api/online-request-steps/';
    protected $modelName = OnlineRequestStep::class;
    protected $defaultTest = false;

    public function testUnauthenticatedGuestCanAccess(): void
    {
        $response = $this->getJson($this->url);
        $this->assertUnauthenticatedRequestResponse($response);
        $this->printSuccessMessage('Unauthenticated user can\'t access online request steps which are handled by him/her.');
    }

    public function testUnauthorizedUserCanAccess(): void
    {
        $user = $this->getUser(UserType::admin());
        $this->assertUnauthorizedUserCanAccess($user);
        $user = $this->getUser(UserType::reception());
        $this->assertUnauthorizedUserCanAccess($user);
        $user = $this->getUser(UserType::itTeam());
        $this->assertUnauthorizedUserCanAccess($user);
        $this->printSuccessMessage('Unauthorized user can\'t access online request steps which are handled by him/her.');

    }

    public function testIndex(): void
    {
        $user = $this->getUser(UserType::staff());
        $this->actingAs($user);
        $response = $this->getJson($this->url);
        $response->assertJson(['status' => 200]);
        $this->printSuccessMessage('Staff user can access online request steps which are handled by him/her.');
    }

    /**
     * @param User $user
     */
    protected function assertUnauthorizedUserCanAccess(User $user): void
    {
        $this->actingAs($user);
        $response = $this->getJson($this->url);
        $response->assertExactJson($this->unauthorizedResponse());
    }
}
