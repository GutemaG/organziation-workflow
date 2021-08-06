<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\OnlineRequestTrackerAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OnlineRequestTrackerController extends Controller
{
    public function applyRequest(Request $request): JsonResponse
    {
        return OnlineRequestTrackerAction::applyRequest($request);
    }
}
