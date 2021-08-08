<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\OnlineRequestTrackerAction;
use App\Http\Requests\OnlineRequestTrackerRequest;
use App\Models\OnlineRequestTracker;
use Illuminate\Http\JsonResponse;

class OnlineRequestTrackerController extends Controller
{
    public function appliedRequest(OnlineRequestTracker $onlineRequestTracker): JsonResponse
    {
        return OnlineRequestTrackerAction::appliedRequest($onlineRequestTracker);
    }

    public function applyRequest(OnlineRequestTrackerRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $response =  OnlineRequestTrackerAction::applyRequest($validatedData);
        return $response;
    }
}
