<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\OnlineRequestTrackerAction;
use App\Http\Requests\OnlineRequestTrackerRequest;
use Illuminate\Http\JsonResponse;

class OnlineRequestTrackerController extends Controller
{
    public function applyRequest(OnlineRequestTrackerRequest $request): JsonResponse
    {
        return OnlineRequestTrackerAction::applyRequest($request->validated());
    }
}
