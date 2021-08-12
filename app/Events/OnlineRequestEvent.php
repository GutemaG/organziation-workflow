<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OnlineRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $onlineRequestStep;
    private $users;
    private $oldNotificationTrackerId;

    /**
     * Create a new event instance.
     *
     * @param User $users
     * @param array $onlineRequestStep
     * @param int|null $oldNotificationTrackerId
     */
    public function __construct(Collection $users, array $onlineRequestStep, int $oldNotificationTrackerId=null)
    {
        $this->onlineRequestStep = $onlineRequestStep;
        $this->users =  $users;
        $this->oldNotificationTrackerId = $oldNotificationTrackerId;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getOldNotificationTrackerId()
    {
        return $this->oldNotificationTrackerId;
    }

    /**
     * @return array
     */
    public function getOnlineRequestStep(): array
    {
        return $this->onlineRequestStep;
    }

}
