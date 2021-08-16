<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\NotificationTrackerAction;
use App\Http\Requests\RejectRequest;
use App\Models\NotificationTracker;
use Illuminate\Http\JsonResponse;

class NotificationTrackerController extends Controller
{
    public function index(): JsonResponse
    {
        return NotificationTrackerAction::index();
    }

    public function onlineRequestAccept(NotificationTracker $notificationTracker): JsonResponse
    {
        return NotificationTrackerAction::onlineRequestAccepted($notificationTracker);
    }

    public function onlineRequestComplete(NotificationTracker $notificationTracker): JsonResponse
    {
        return NotificationTrackerAction::onlineRequestCompleted($notificationTracker);
    }

    public function onlineRequestReject(RejectRequest $request, NotificationTracker $notificationTracker): JsonResponse
    {
        $reason = $request->validated()['reason'];
        return NotificationTrackerAction::onlineRequestReject($notificationTracker, $reason);
    }
}
