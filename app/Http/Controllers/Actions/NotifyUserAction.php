<?php


namespace App\Http\Controllers\Actions;


use App\Models\NotificationTracker;
use App\Models\NotifiedUser;
use Illuminate\Support\Collection;

class NotifyUserAction
{
    public static function index(): array
    {
        $notifiedUsers = NotifiedUser::with('notificationTracker.onlineRequestStep.onlineRequestTracker.onlineRequest')
            ->where('is_accepted', false)->where('user_id', auth()->user()->id)->get();
        $onlineRequestSteps = $notifiedUsers->map(function ($value) {
            $temp = $value->notificationTracker->onlineRequestStep->toArray();
            $temp['notification_tracker_id'] = $value->notificationTracker->id;
            $temp['online_request'] = $value->notificationTracker->onlineRequestStep->onlineRequestTracker->onlineRequest->toArray();
            $client_data = $value->notificationTracker->onlineRequestStep->onlineRequestTracker->clientInformation;
            $client_data['full_name'] = $value->notificationTracker->onlineRequestStep->onlineRequestTracker->full_name;
            $temp['client_data'] = $client_data;
            unset($temp['online_request_tracker']);
            return $temp;
        });

        return $onlineRequestSteps->toArray();
    }

    public static function store(array $data): void
    {
        NotifiedUser::insert($data);
    }

    public static function accepted(NotificationTracker $notificationTracker): void
    {
        $notificationTracker->notifiedUsers()->update(['is_accepted' => true]);
    }

    public static function delete(NotificationTracker $notificationTracker): void
    {
        if ($notificationTracker) {
            $notificationTracker->notifiedUsers()->delete();
            $notificationTracker->delete();
        }
    }

    public static function usersId(NotificationTracker $notificationTracker): array
    {
        return $notificationTracker->notifiedUsers->map(function ($value){
            if (! $value->is_accepted)
                return $value->user_id;
            return null;
        })->filter(function ($value){
            return $value!= null;
        })->toArray();
    }
}
