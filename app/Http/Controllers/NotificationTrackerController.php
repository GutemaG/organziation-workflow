<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\NotificationTrackerAction;
use App\Models\NotificationTracker;
use Illuminate\Http\JsonResponse;

class NotificationTrackerController extends Controller
{
    public function index(): JsonResponse
    {
        return NotificationTrackerAction::index();
    }

    public function onlineRequestAccepted(NotificationTracker $notificationTracker): JsonResponse
    {
        return NotificationTrackerAction::onlineRequestAccepted($notificationTracker);
    }

    public function onlineRequestCompleted(NotificationTracker $notificationTracker): JsonResponse
    {
        return NotificationTrackerAction::onlineRequestCompleted($notificationTracker);
    }
}
