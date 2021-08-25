<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\MyJsonResponse;
use App\Http\Controllers\Actions\NotificationTrackerAction;
use App\Http\Requests\RejectRequest;
use App\Models\NotificationTracker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class NotificationTrackerController extends Controller
{
    use MyJsonResponse;

    public function __construct() {
        $this->middleware(function($request, $next){
            if (Gate::check('is-staff'))
                return $next($request);
            return self::unauthorizedResponse();
        });
    }

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
