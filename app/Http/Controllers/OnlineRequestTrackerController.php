<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\OnlineRequestTrackerAction;
use App\Models\OnlineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlineRequestTrackerController extends Controller
{
    public function applyRequest(OnlineRequest $onlineRequest): JsonResponse
    {
        return OnlineRequestTrackerAction::applyRequest($onlineRequest);
    }
}
