<?php

namespace Tests\Feature;

use App\Models\OnlineRequest;
use App\Models\OnlineRequestTracker;
use App\Utilities\InputFieldType;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class OnlineRequestTrackerTest extends MyTestCase
{
    protected string $url = '/api/apply-request/';
    protected string $modelName = OnlineRequestTracker::class;
    protected bool $defaultTest = false;

    public function testApplyRequestWithInvalidData(): void
    {
        $response = $this->postJson($this->url, []);
        $response->assertExactJson([
            'status' => 422,
            'error' => [
                'online_request_id' => ['The online request id field is required.'],
                'phone_number' => ['The phone number field is required.'],
                'full_name' => ['The full name field is required.'],
            ]
        ]);
        $this->printSuccessMessage('Customer can\'t apply online request with invalid data passed ');
    }

    public function testApplyRequestWithInvalidPhoneNumber(): void
    {
        $onlineRequest = $this->randomData(OnlineRequest::class, ['onlineRequestPrerequisiteInputs']);
        $error = [];
        foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input) {
            $error[$input->name] = ["The $input->name field is required."];
        }
        $response = $this->postJson($this->url, ['online_request_id' => $onlineRequest->id,'full_name' => 'henok', 'phone_number' => '+251943536363']);
        $response->assertExactJson([
            'status' => 422,
            'error' =>  $error
        ]);
        $this->printSuccessMessage('Customer can\'t apply request with unregistered phone number passed ');
    }

//    public function testApplyRequestWithValidData(): void
//    {
//        $onlineRequest = $this->randomData(OnlineRequest::class, ['onlineRequestPrerequisiteInputs']);
//        $error = [];
//        foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input) {
//            $error[$input->name] = ["The $input->name field is required."];
//        }
//        $response = $this->postJson($this->url, ['online_request_id' => $onlineRequest->id,'full_name' => 'henok', 'phone_number' => '+251985190194'])
//                    ->assertExactJson(['status' => 422, 'error' => $error]);
//
//        $data = ['online_request_id' => $onlineRequest->id,'full_name' => 'henok', 'phone_number' => '+251985190194'];
//        foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input) {
//            $data[$input->name] = $this->getData($input->type);
//        }
//        dump($data);
//        $response = $this->postJson($this->url,$data)->dump();dd();
//        $token = OnlineRequestTracker::orderBy('id', 'DESC')->limit(1)->get()->first()->token;
//        $response->assertExactJson([
//            'status' => 200,
//            'token' => $token,
//        ]);
//        $this->printSuccessMessage('Customer can apply online request passed ');
//    }
//
//    protected function getData(string $type): string
//    {
//        switch ($type) {
//            case InputFieldType::getEmail():
//                return 'henok@gmail.com';
//                break;
//            case InputFieldType::getText():
//                return 'required string';
//                break;
//            case InputFieldType::getNumber():
//                return 56456;
//                break;
//            case InputFieldType::getFile():
//                Storage::fake('document.pdf');
//                $file = UploadedFile::fake()->create('document.pdf');;
//                dump('ksjdkfsjdfkljs');
//                return $file;
//                break;
//            default:
//                return '';
//                break;
//        }
//    }
}
