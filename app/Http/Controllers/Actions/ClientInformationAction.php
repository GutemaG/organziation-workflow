<?php


namespace App\Http\Controllers\Actions;


use App\Models\ClientInformation;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestTracker;

class ClientInformationAction
{
    public static function store(array $data, OnlineRequestTracker $onlineRequestTracker): void
    {
        $temp = array();
        $onlineRequest = OnlineRequest::with(['onlineRequestPrerequisiteInputs'])->find($data['online_request_id']);
        foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input) {
            $temp[$input->name] = $input->type != file
                ? $onlineRequestTracker->clientInformation->create(['name' => $input->name, 'value' => $data[$input->name], 'is_file' => false])
                : $onlineRequestTracker->clientInformation->create(['name' => $input->name, 'value' => $data[$input->name], 'is_file' => true]);
        }
    }
}
