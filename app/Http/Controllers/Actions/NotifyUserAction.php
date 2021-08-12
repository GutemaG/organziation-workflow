<?php


namespace App\Http\Controllers\Actions;


use App\Models\NotificationTracker;
use App\Models\NotifiedUser;
use Illuminate\Support\Collection;

class NotifyUserAction
{
    public static function index(): Collection
    {
        return NotifiedUser::with('notificationTracker:id')->where('is_accepted', false)->where('user_id', auth()->user()->id)->get();
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
            return $value->user_id;
        })->toArray();
    }
}
