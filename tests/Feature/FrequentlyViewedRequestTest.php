<?php

namespace Tests\Feature;

use App\Models\Affair;
use App\Models\OnlineRequest;
use App\Models\User;
use App\Utilities\UserType;

class FrequentlyViewedRequestTest extends MyTestCase
{
    protected bool $defaultTest = false;

    public function testIncrementOnlineRequest(): void
    {
        $this->testWithUnexistRequest(OnlineRequest::class, '/api/online-requests/increment');
        $this->testClientCanIncrementRequest(OnlineRequest::class, '/api/online-requests/increment');
        $this->testAuthenticatedUserCantIncrementRequest(OnlineRequest::class, '/api/online-requests/increment');
        $this->printSuccessMessage('increment online request passed ');
    }

    public function testFrequentlyViewedOnlineRequest(): void
    {
        $limit = rand(0, 5);
        $limit = $limit >= 10 ? $limit : 10;
        $onlineRequest = OnlineRequest::orderBy('views', 'asc')
            ->limit($limit)->get()->toArray();
        $this->getJson("/api/online-requests/most-viewed/$limit")
            ->assertExactJson(['status' => 200, 'online_requests' => $onlineRequest]);
        $this->printSuccessMessage('get most viewed online request passed ');
    }

    public function testIncrementAffair(): void
    {
        $this->testWithUnexistRequest(Affair::class, '/api/affairs/increment');
        $this->testClientCanIncrementRequest(Affair::class, '/api/affairs/increment');
        $this->testAuthenticatedUserCantIncrementRequest(Affair::class, '/api/affairs/increment');
        $this->printSuccessMessage('increment affair passed ');
    }

    public function testFrequentlyViewedAffair(): void
    {
        $limit = rand(0, 5);
        $limit = $limit >= 10 ? $limit : 10;
        $affairs = Affair::orderBy('views', 'asc')
            ->limit($limit)->get()->toArray();
        $this->getJson("/api/affairs/most-viewed/$limit")
            ->assertExactJson(['status' => 200, 'affairs' => $affairs]);
        $this->printSuccessMessage('get most viewed affair passed ');
    }

    private function randomUser(): User
    {
        $usersType = UserType::all();
        $index = array_rand($usersType);
        $user = $this->getUser($usersType[$index]);
        while ($user == null) {
            $index = array_rand($usersType);
            $user = $this->getUser($usersType[$index]);
        }
        return  $user;
    }

    private function testAuthenticatedUserCantIncrementRequest(string $modelName, string $url): void
    {
        $user = $this->randomUser();
        $request = $this->randomData($modelName);
        $this->actingAs($user);
        $this->getJson("$url/$request->id")->assertExactJson([
            'status' => 400,
            'error' => ['User must be client.'],
        ]);
    }

    private function testClientCanIncrementRequest(string $modelName, string $url): void
    {
        $request = $this->randomData($modelName);
        $this->getJson("$url/$request->id")->assertExactJson(['status' => 200]);
        $this->assertEquals($request->views + 1, $request->refresh()->views);
    }

    private function testWithUnexistRequest(string $modelName, string $url): void
    {
        $id = $modelName == OnlineRequest::class ?
            OnlineRequest::orderByDesc('id')->limit(1)->get()->first()->id + 1
            : Affair::orderByDesc('id')->limit(1)->get()->first()->id + 1;
        $this->getJson("$url/$id")
            ->assertExactJson(['status' => 404, 'error' => ['error' => ['Not found.']]]);
    }

}
