<?php


namespace App\Http\Controllers\Actions;


use App\Events\NotifyUserEvent;
use App\Models\NotificationTracker;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class NotificationTrackerAction
{
    use MyJsonResponse;

    /**
     * Return all online request step the logged in user is responsible and not accepted by any one.
     *
     * @return JsonResponse
     */
    public static function index(): JsonResponse
    {
        $data = NotifyUserAction::index();
        return self::successResponse(['online_request_steps' => $data]);
    }

    /**
     * If the current logged in user is authorized to accept the online request step requested;
     * this make the logged in user responsible for the online request step requested.
     *
     * @param NotificationTracker $notificationTracker
     * @return JsonResponse
     */
    public static function onlineRequestAccepted(NotificationTracker $notificationTracker): JsonResponse
    {
        $authorizedUsersId = NotifyUserAction::usersId($notificationTracker);
        if (Gate::check('is-staff') && in_array(auth()->user()->id, $authorizedUsersId)) {
            NotifyUserAction::accepted($notificationTracker);
            OnlineRequestStepAction::assignResponsibleUser($notificationTracker->onlineRequestStep);
            return self::successResponse();
        }
        return self::unauthorizedResponse();
    }

    public static function onlineRequestCompleted(NotificationTracker $notificationTracker): JsonResponse
    {
        //            $nextOnlineRequestStep = $notificationTracker->onlineRequestStep->nextStep;
        //            NotifyUserAction::delete($notificationTracker);


    }


}
