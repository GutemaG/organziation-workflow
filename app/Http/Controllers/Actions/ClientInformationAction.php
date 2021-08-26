<?php


namespace App\Http\Controllers\Actions;


use App\Models\ClientInformation;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestTracker;

class ClientInformationAction
{
    public static function store(array $data, OnlineRequestTracker $onlineRequestTracker): void
    {
        $onlineRequest = OnlineRequest::with(['onlineRequestPrerequisiteInputs'])->find($data['online_request_id']);

        foreach ($onlineRequest->onlineRequestPrerequisiteInputs as $input) {
            if ($input->type != 'file')
               ClientInformation::create([
                   'online_request_tracker_id' => $onlineRequestTracker->id,
                   'name' => $input->name, 'value' => $data['prerequisites'][$input->name],
                   'is_file' => false
               ]);
            else
                ClientInformation::create([
                    'online_request_tracker_id' => $onlineRequestTracker->id,
                    'name' => $input->name, 'value' => $data['prerequisites'][$input->name],
                    'is_file' => true
                ]);
        }
    }
}
