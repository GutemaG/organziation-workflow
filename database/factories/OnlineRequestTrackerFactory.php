<?php

namespace Database\Factories;

use App\Models\OnlineRequestTracker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OnlineRequestTrackerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OnlineRequestTracker::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'online_request_id' => Utility::getOnlineRequestId(),
            'started_at' => now(),
            'ended_at' => now(),
            'token' => Str::random(6),
        ];
    }
}
