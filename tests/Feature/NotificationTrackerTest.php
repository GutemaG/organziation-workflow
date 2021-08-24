<?php

namespace Tests\Feature;

use App\Http\Controllers\Utilities\UserType;
use App\Models\NotificationTracker;
use App\Models\NotifiedUser;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestProcedure;
use App\Models\OnlineRequestStep;
use App\Models\OnlineRequestTracker;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use function Doctrine\Common\Cache\Psr6\get;

class NotificationTrackerTest extends MyTestCase
{
    protected string $url = '/api/online-request-applied';
    protected string $modelName = NotificationTracker::class;
    protected bool $defaultTest = false;
    protected OnlineRequest $onlineRequest;
    protected Collection $users;
    protected User $user;
    protected Collection $procedures;
    protected OnlineRequestProcedure $procedure;
    protected TestResponse $response;
    protected Collection $notificationTracker;

    public function setUp(): void
    {
        parent::setUp();
        list($this->onlineRequest, $this->procedures, $this->procedure, $this->users, $this->response) = $this->applyOnlineRequest();
        $this->user = $this->users->random();
        $this->notificationTracker = NotificationTracker::with('notifiedUsers')->get();
    }

    public function testDefaultTest(): void
    {
        $notificationTrackerId = $this->notificationTracker->first()->id;
        $userTypes = [UserType::itTeam(), UserType::reception(), UserType::admin()];
        foreach ($userTypes as $userType) {
            $user = $this->getUser($userType);
            $this->actingAs($user);
            $this->getJson($this->url)->assertExactJson($this->unauthorizedResponse());
            $this->getJson("$this->url/accept/$notificationTrackerId")->assertExactJson($this->unauthorizedResponse());
            $this->getJson("$this->url/complete/$notificationTrackerId")->assertExactJson($this->unauthorizedResponse());
            $this->putJson("$this->url/reject/$notificationTrackerId")->assertExactJson($this->unauthorizedResponse());
        }
        $this->printSuccessMessage('NotificationTracker feature is authorized only for staff user passed ');
    }

    public function testIndex(): void
    {
        $onlineRequestStepId = $this->assertOnlineRequestTracker();
        $this->assertNotificationTracker($onlineRequestStepId);
        $this->assertNotificationTrackerIndex();
        $this->assertForUnNotifiedUser();
        $this->printSuccessMessage('test of index function is passed ');
    }

    public function testAccept(): void
    {
        $notificationTrackerId = $this->notificationTracker->first()->id;
        $this->assertUnnotifiedUserUnauthorizedToAccept($notificationTrackerId);
        $this->assertNotifiedUserCanAccept($notificationTrackerId);
        $this->assertNotificationTrackerIndex();
        foreach ($this->notificationTracker->first()->notifiedUsers as $notifiedUser) {
            $notifiedUser->refresh();
            $this->assertEquals(1, $notifiedUser->is_accepted);
        }
        $this->assertAlreadyAccepted('accept', $notificationTrackerId);
        $this->printSuccessMessage('test of accept function is passed ');
    }

    public function testComplete(): void
    {
        $onlineRequestStep = null;
        $notificationTrackerId = $this->notificationTracker->first()->id;
        $this->assertNotifiedUserCanAccept($notificationTrackerId); // the notification must be accepted before completed.
        $this->assertUnnotifiedUserUnauthorizedToComplete($notificationTrackerId);
        $this->actingAs($this->user);
        $response = $this->getJson("$this->url/complete/$notificationTrackerId");
        if ($this->procedures->count() > 1) {
            $response->assertExactJson(['status' => 200]);
            $onlineRequestStep = $this->assertOnlineRequestStepUpdated(true);
        }
        else {
            $response->assertExactJson([
                'status' => 200,
                'message' => "Request completed successfully.",
            ]);
            $onlineRequestStep = $this->assertOnlineRequestStepUpdated(true, true);
        }
        $this->assertEquals(1, $onlineRequestStep->is_completed);
        $this->assertEquals(0, $onlineRequestStep->is_rejected);
        $this->assertSoftDeleted($this->notificationTracker->first());
        foreach ($this->notificationTracker->first()->notifiedUsers as $notifiedUser)
            $this->assertSoftDeleted($notifiedUser);
        $this->assertAlreadyAccepted('complete', $notificationTrackerId);
        $this->printSuccessMessage('test of complete function is passed ');
    }

    public function testReject()
    {
        $onlineRequestTracker = null;
        $notificationTrackerId = $this->notificationTracker->first()->id;
        $this->assertNotifiedUserCanAccept($notificationTrackerId); // the notification must be accepted before completed.
        $this->assertUnnotifiedUserUnauthorizedToReject($notificationTrackerId);
        $this->assertStaffUserCantRejectWithOutReason($notificationTrackerId);
        $this->assertStaffUserCanRejectWithReason($notificationTrackerId);
        $this->assertAlreadyAccepted('reject', $notificationTrackerId);
        $this->printSuccessMessage('test of complete function is passed ');
    }

    /**
     * Assert that staff user can't reject with out reason.
     *
     * @param int $notificationTrackerId
     */
    private function assertStaffUserCantRejectWithOutReason(int $notificationTrackerId): void
    {
        $this->actingAs($this->user);
        $response = $this->putJson("$this->url/reject/$notificationTrackerId", []);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'reason' => ['The reason field is required.'],
            ]
        ]);
    }

    /**
     * Assert that staff user can reject with reason.
     *
     * @param int $notificationTrackerId
     */
    private function assertStaffUserCanRejectWithReason(int $notificationTrackerId): void
    {
        $this->actingAs($this->user);
        $response = $this->putJson("$this->url/reject/$notificationTrackerId", ['reason' => 'this is test reason']);
        $response->assertExactJson([
            'status' => 200,
            'message' => 'Request rejected successfully.',
        ]);
        $onlineRequestStep = $this->assertOnlineRequestStepUpdated(true, true);
        $this->assertEquals(0, $onlineRequestStep->is_completed);
        $this->assertEquals(1, $onlineRequestStep->is_rejected);
        $this->assertSoftDeleted($this->notificationTracker->first());
        foreach ($this->notificationTracker->first()->notifiedUsers as $notifiedUser)
            $this->assertSoftDeleted($notifiedUser);
    }

    /**
     * Assert if the created online request tracker and online request step is correct.
     *
     * @return int
     */
    private function assertOnlineRequestTracker(): int
    {
        $onlineRequestTracker = OnlineRequestTracker::all();
        $onlineRequestSteps = OnlineRequestStep::all()->sortBy('id');
        $this->assertEquals($this->onlineRequest->id, $this->procedure->online_request_id);
        $this->assertEquals(1, $onlineRequestTracker->count());
        $this->assertEquals($this->onlineRequest->id, $onlineRequestTracker->first()->online_request_id);
        $this->assertEquals($this->response->json()['token'], $onlineRequestTracker->first()->token);
        $this->assertEquals($this->procedures->count(), $onlineRequestSteps->count());
        $length = $onlineRequestSteps->count();
        for ($i = 1; $i < $length; $i++)
            $this->assertEquals($onlineRequestSteps->get($i - 1)->next_step, $onlineRequestSteps->get($i)->id);
        $this->assertEquals(null, $onlineRequestSteps->last()->next_step);
        return $onlineRequestSteps->first()->id;
    }

    /**
     * Apply online request.
     *
     * @return array
     */
    private function applyOnlineRequest(): array
    {
        $onlineRequest = $this->randomData(OnlineRequest::class, ['onlineRequestProcedures.users']);
        $procedures = $onlineRequest->onlineRequestProcedures;
        $procedure = $procedures->firstWhere('step_number', 1);
        $users = $procedure->users;
        $response = $this->postJson('/api/apply-request/', [
            'online_request_id' => $onlineRequest->id,
            'phone_number' => '+251985190194',
        ]);
        return array($onlineRequest, $procedures, $procedure, $users, $response);
    }

    /**
     * Assert if the created notification tracker and notified users are correct.
     *
     * @param int $onlineRequestStepId
     * @return mixed
     */
    private function assertNotificationTracker(int $onlineRequestStepId): int
    {
        $this->assertEquals(1, $this->notificationTracker->count());
        $this->assertEquals($onlineRequestStepId, $this->notificationTracker->first()->online_request_step_id);
        $this->assertDatabaseCount('notified_users', $this->users->count());
        $length = $this->users->count();
        $notificationTrackerId = $this->notificationTracker->first()->id;
        foreach ($this->users as $user)
            $this->assertDatabaseHas('notified_users', [
                'notification_tracker_id' => $notificationTrackerId,
                'user_id' => $user->id,
                'is_accepted' => false,
            ]);
        return $notificationTrackerId;
    }

    /**
     * Assert if the returned data is correct for the logged in user.
     *
     */
    private function assertNotificationTrackerIndex(): void
    {
        $this->actingAs($this->user);
        $response = $this->getJson($this->url);
        $notifiedUsers = NotifiedUser::with('notificationTracker.onlineRequestStep.onlineRequestTracker.onlineRequest')
            ->where('is_accepted', false)->where('user_id', auth()->user()->id)->get();
        $onlineRequestSteps = $notifiedUsers->map(function ($value) {
            $temp = $value->notificationTracker->onlineRequestStep->toArray();
            $temp['notification_tracker_id'] = $value->notificationTracker->id;
            $temp['online_request'] = $value->notificationTracker->onlineRequestStep->onlineRequestTracker->onlineRequest->toArray();
            unset($temp['online_request_tracker']);
            return $temp;
        })->toArray();
        $response->assertExactJson([
            'status' => 200,
            'online_request_steps' => $onlineRequestSteps
        ]);
    }

    /**
     * Assert that unnotified staff user has no notification.
     */
    private function assertForUnnotifiedUser(): void
    {
        $user = $this->getUnnotifiedUser();
        $this->actingAs($user);
        $response = $this->getJson($this->url);
        $response->assertExactJson([
            'status' => 200,
            'online_request_steps' => [],
        ]);
    }

    /**
     * Return unnotified staff user randomly.
     *
     * @return User
     */
    private function getUnnotifiedUser(): User
    {
        $usersId = $this->users->map(function ($value) {
            return $value->id;
        });
        return User::inRandomOrder()->whereNotIn('id', $usersId)->where('type', 'staff')
                        ->limit(1)->get()->first();
    }

    /**
     * Assert that unnotified user can't accept the notification sent to user users.
     *
     * @param $notificationTrackerId
     */
    private function assertUnnotifiedUserUnauthorizedToAccept($notificationTrackerId): void
    {
        $this->actingAs($this->getUnnotifiedUser());
        $response = $this->getJson("$this->url/accept/$notificationTrackerId");
        $response->assertExactJson([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }

    /**
     * Assert that notified user can accept the notification sent to hin/her.
     *
     * @param $notificationTrackerId
     */
    private function assertNotifiedUserCanAccept($notificationTrackerId): void
    {
        $this->actingAs($this->user);
        $response = $this->getJson("$this->url/accept/$notificationTrackerId");
        $response->assertExactJson([
            'status' => 200,
        ]);
        $this->assertOnlineRequestStepUpdated();
    }

    /**
     * Assert that unnotified user can't complete the notification sent to user users.
     *
     * @param $notificationTrackerId
     */
    private function assertUnnotifiedUserUnauthorizedToComplete($notificationTrackerId): void
    {
        $this->actingAs($this->getUnnotifiedUser());
        $response = $this->getJson("$this->url/complete/$notificationTrackerId");
        $response->assertExactJson([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }

    /**
     * Check start_at and ended_at status for both onlineRequestTracker and onlineRequestStep is updated.
     *
     * @param bool $stepEnded
     * @param bool $trackerEnded
     * @return OnlineRequestStep
     */
    private function assertOnlineRequestStepUpdated(bool $stepEnded=false, bool $trackerEnded=false): OnlineRequestStep
    {
        $onlineRequestStep = $this->notificationTracker->first()->onlineRequestStep;
        $onlineRequestStep->refresh();
        $onlineRequestTracker = $onlineRequestStep->onlineRequestTracker;
        $this->assertNotNull($onlineRequestStep->started_at);
        $stepEnded ? $this->assertNotNull($onlineRequestStep->ended_at) : $this->assertNull($onlineRequestStep->ended_at);
        $this->assertEquals($onlineRequestStep->user_id, $this->user->id);
        $this->assertNotNull($onlineRequestTracker->started_at);
        $trackerEnded ? $this->assertNotNull($onlineRequestTracker->ended_at) : $this->assertNull($onlineRequestTracker->ended_at);
        return $onlineRequestStep;
    }

    /**
     * Assert that unnotified user can't reject the notification sent to user users.
     *
     * @param $notificationTrackerId
     */
    private function assertUnnotifiedUserUnauthorizedToReject($notificationTrackerId): void
    {
        $this->actingAs($this->getUnnotifiedUser());
        $response = $this->putJson("$this->url/reject/$notificationTrackerId", ['reason' => 'test']);
        $response->assertExactJson([
            'status' => 403,
            'error' => [
                'error' => ['Unauthorized.'],
            ],
        ]);
    }

    /**
     * Assert that any once the notification tracker is accepted it can't be accepted by any one even by the staff user it accepted.
     * Assert that any once the notification tracker is completed it can't be completed by any one even by the staff user it completed.
     * Assert that any once the notification tracker is rejected it can't be rejected by any one even by the staff user it rejected.
     *
     * @param string $action
     * @param int $notificationTrackerId
     */
    private function assertAlreadyAccepted(string $action, int $notificationTrackerId): void
    {
        $user = $this->users->first(function ($value) {
            return $this->user != $value;
        });
        if ($user) {
            if ($action == 'reject') {
                $this->actingAs($user);
                $this->putJson("$this->url/$action/$notificationTrackerId")->assertExactJson([
                    'status' => 404,
                    'error' => [
                        'error' => ['Not found.'],
                    ],
                ]);
                $this->actingAs($this->user);
                $this->putJson("$this->url/$action/$notificationTrackerId")->assertExactJson([
                    'status' => 404,
                    'error' => [
                        'error' => ['Not found.'],
                    ],
                ]);
            }
            elseif ($action == 'accept') {
                $this->actingAs($user);
                $this->getJson("$this->url/$action/$notificationTrackerId")->assertExactJson([
                    'status' => 400,
                    'error' => ['Already accepted.'],
                ]);
                $this->actingAs($this->user);
                $this->getJson("$this->url/$action/$notificationTrackerId")->assertExactJson([
                    'status' => 400,
                    'error' => ['Already accepted.'],
                ]);
            }
            else {
                $this->actingAs($user);
                $this->getJson("$this->url/$action/$notificationTrackerId")->assertExactJson([
                    'status' => 404,
                    'error' => [
                        'error' => ['Not found.'],
                    ],
                ]);
                $this->actingAs($this->user);
                $this->getJson("$this->url/$action/$notificationTrackerId")->assertExactJson([
                    'status' => 404,
                    'error' => [
                        'error' => ['Not found.'],
                    ],
                ]);
            }
        }
    }
}
