<?php


namespace App\Http\Controllers\Actions;


use App\Models\NotificationTracker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class NotificationTrackerAction
{
    use MyJsonResponse;

    public static function index(): JsonResponse
    {
        $data = NotifyUserAction::index()->toArray();
        return self::successResponse($data);
    }

    public static function onlineRequestAccepted(NotificationTracker $notificationTracker): JsonResponse
    {
        $authorizedUsersId = NotifyUserAction::usersId($notificationTracker);
        if (Gate::check('is-staff') && in_array(auth()->user()->id, $authorizedUsersId)) {
            NotifyUserAction::accepted($notificationTracker);
        }
        return self::unauthorizedResponse();
    }

    //            $nextOnlineRequestStep = $notificationTracker->onlineRequestStep->nextStep;
//            NotifyUserAction::delete($notificationTracker);

}
