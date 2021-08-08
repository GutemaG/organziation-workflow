<?php

namespace Tests\Feature;

use App\Models\OnlineRequest;
use App\Models\OnlineRequestTracker;

class OnlineRequestTrackerTest extends MyTestCase
{
    protected $url = '/api/apply-request/';
    protected $modelName = OnlineRequestTracker::class;
    protected $defaultTest = false;

    public function testApplyRequestWithInvalidData(): void
    {
        $response = $this->postJson($this->url, []);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'online_request_id' => ['The online request id field is required.'],
                'phone_number' => ['The phone number field is required.']
            ]
        ]);
        $this->printSuccessMessage('Customer can\'t apply online request with invalid data passed ');
    }

    public function testApplyRequestWithInvalidPhoneNumber(): void
    {
        $id = $this->randomData(OnlineRequest::class)->id;
        $response = $this->postJson($this->url, ['online_request_id' => $id, 'phone_number' => '+251943536363']);
        $response->assertExactJson([
            'status' => 400,
            'error' => [
                'error' => [
                    "something went wrong. Please try again.",
                    "The system can't send sms; may be your phone number is not registered!",
                ]
            ]
        ]);
        $this->printSuccessMessage('Customer can\'t apply request with unregistered phone number passed ');
    }

    public function testApplyRequestWithValidData(): void
    {
        $response = $this->postJson($this->url, ['online_request_id' => 2, 'phone_number' => '+251953960596']);
        $token = OnlineRequestTracker::orderBy('id', 'DESC')->limit(1)->get()->first()->token;
        $response->assertExactJson([
            'status' => 200,
            'token' => $token,
        ]);
        $this->printSuccessMessage('Customer can apply online request passed ');
    }
}
