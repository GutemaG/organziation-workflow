<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OnlineRequestEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $onlineRequestStep;
    private $user;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param array $onlineRequestStep
     */
    public function __construct(User $user, array $onlineRequestStep)
    {
        $this->onlineRequestStep = $onlineRequestStep;
        $this->user =  $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        return new PrivateChannel('online-request-applied');
        return new PrivateChannel($this->user->id . '.' . 'online-request-applied');
    }
}
