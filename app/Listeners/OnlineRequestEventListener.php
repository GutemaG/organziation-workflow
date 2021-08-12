<?php

namespace App\Listeners;

use App\Events\NotifyUserEvent;
use App\Events\OnlineRequestEvent;
use App\Models\NotificationTracker;
use App\Models\NotifiedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OnlineRequestEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OnlineRequestEvent  $event
     * @return void
     */
    public function handle(OnlineRequestEvent $event)
    {
        $this->registerCurrentNotifiedUser($event);
        $this->deleteOldNotification($event);
    }

    /**
     * @param OnlineRequestEvent $event
     */
    protected function registerCurrentNotifiedUser(OnlineRequestEvent $event): void
    {
        $notificationTracker = NotificationTracker::create([
            'online_request_step_id' => $event->getOnlineRequestStep()['id'],
        ]);
        $users = $event->getUsers()->map(function ($value) use ($notificationTracker){
            return ['user_id' => $value->id, 'notification_tracker_id' => $notificationTracker->id];
        })->toArray();
        NotifiedUser::insert($users);
        $onlineRequestStep = $event->getOnlineRequestStep();
        $onlineRequestStep['notification_tracker_id'] = $notificationTracker->id;
        NotifyUserEvent::dispatch($event->getUsers(), $onlineRequestStep);
    }

    /**
     * @param OnlineRequestEvent $event
     */
    protected function deleteOldNotification(OnlineRequestEvent $event): void
    {
        if ($event->getOldNotificationTrackerId()) {
            $notificationTracker = NotificationTracker::find($event->getOldNotificationTrackerId());
            if ($notificationTracker) {
                $notificationTracker->notifiedUsers()->delete();
                $notificationTracker->delete();
            }
        }
    }
}
