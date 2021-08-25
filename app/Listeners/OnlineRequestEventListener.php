<?php

namespace App\Listeners;

use App\Events\NotifyUserEvent;
use App\Events\OnlineRequestEvent;
use App\Http\Controllers\Actions\NotificationTrackerAction;
use App\Http\Controllers\Actions\NotifyUserAction;
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
    }

    /**
     * @param OnlineRequestEvent $event
     */
    protected function registerCurrentNotifiedUser(OnlineRequestEvent $event): void
    {
        $notificationTracker = NotificationTrackerAction::store($event->getOnlineRequestStep()['id']);
        $data = $event->getUsers()->map(function ($value) use ($notificationTracker){
            return ['user_id' => $value->id, 'notification_tracker_id' => $notificationTracker->id];
        })->toArray();
        NotifyUserAction::store($data);
        $onlineRequestStep = $event->getOnlineRequestStep();
        $onlineRequestStep['notification_tracker_id'] = $notificationTracker->id;
       NotifyUserEvent::dispatch($event->getUsers(), $onlineRequestStep);
    }
}
