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
     * Store notification tracker.
     *
     * @param array $onlineRequestStepId
     * @return NotificationTracker
     */
    public static function store(int $onlineRequestStepId): NotificationTracker
    {
        return NotificationTracker::create([
            'online_request_step_id' => $onlineRequestStepId,
        ]);
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
        if (in_array(auth()->user()->id, $authorizedUsersId)) {
            $onlineRequestStep = $notificationTracker->onlineRequestStep;
            NotifyUserAction::accepted($notificationTracker);
            OnlineRequestStepAction::assignResponsibleUser($onlineRequestStep);
            if ($onlineRequestStep->onlineRequestProcedure->step_number == 1)
                $onlineRequestStep->onlineRequestTracker->update(['started_at' => now()]);
            return self::successResponse();
        }
        elseif (empty($authorizedUsersId))
            return self::successResponse(['error' => ['Already accepted.']], 400);
        return self::unauthorizedResponse();
    }

    /**
     * Make the online request step complete and if the next next step exits send the notification
     * to the staff users responsible for the next online request step.
     *
     * @param NotificationTracker $notificationTracker
     * @return JsonResponse
     */
    public static function onlineRequestCompleted(NotificationTracker $notificationTracker): JsonResponse
    {
        $onlineRequestStep = $notificationTracker->onlineRequestStep;
        if ($onlineRequestStep->user_id == auth()->user()->id) {
            $nextOnlineRequestStep = $onlineRequestStep->nextStep;
            OnlineRequestStepAction::complete($onlineRequestStep);
            NotifyUserAction::delete($notificationTracker);
            if ($nextOnlineRequestStep) {
                $notificationTracker = self::store($nextOnlineRequestStep->id);
                $users = $nextOnlineRequestStep->onlineRequestProcedure->users;
                $data = $users->map(function ($value) use ($notificationTracker){
                    return ['user_id' => $value->id, 'notification_tracker_id' => $notificationTracker->id];
                })->toArray();
                NotifyUserAction::store($data);
                $onlineRequest = $nextOnlineRequestStep->onlineRequestProcedure->onlineRequest->toArray();
                $nextOnlineRequestStep = $nextOnlineRequestStep->toArray();
                unset($nextOnlineRequestStep['online_request_procedure']);
                $nextOnlineRequestStep['online_request'] = $onlineRequest;
                $nextOnlineRequestStep['notification_tracker_id'] = $notificationTracker->id;
//            NotifyUserEvent::dispatch($users, $nextOnlineRequestStep);
                return self::successResponse();
            }
            $onlineRequestStep->onlineRequestTracker->update(['ended_at' => now()]);
            return self::successResponse(['message' => 'Request completed successfully.']);
        }
        return self::unauthorizedResponse();
    }

    public static function onlineRequestReject(NotificationTracker $notificationTracker, string $reason): JsonResponse
    {
        $onlineRequestStep = $notificationTracker->onlineRequestStep;
        if ($onlineRequestStep->user_id == auth()->user()->id) {
            OnlineRequestStepAction::reject($onlineRequestStep, $reason);
            NotifyUserAction::delete($notificationTracker);
            $onlineRequestStep->onlineRequestTracker->update(['ended_at' => now()]);
            return self::successResponse(['message' => 'Request rejected successfully.']);
        }
        return self::unauthorizedResponse();
    }
}
