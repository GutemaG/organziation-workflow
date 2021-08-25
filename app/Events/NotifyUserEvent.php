<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class NotifyUserEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $onlineRequestStep;
    private $users;

    /**
     * Create a new event instance.
     *
     * @param Collection $users
     * @param array $onlineRequestStep
     */
    public function __construct(Collection $users, array $onlineRequestStep)
    {
        $this->onlineRequestStep = $onlineRequestStep;
        $this->users =  $users;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return $this->getChannels();
    }

    /**
     * @return array
     */
    protected function getChannels(): array
    {
        return $this->users->map(function ($user) {
            return new PrivateChannel($user->id . '.' . 'online-request-applied');
        })->toArray();
    }
}
