<?php


namespace Tests\Feature\Utilities;


use App\Models\Affair;
use App\Models\FrequentlyAskedQuestion;
use App\Models\OnlineRequest;
use App\Models\OnlineRequestTracker;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ModelInstances
{
    protected function getUser(string $userType): ?User
    {
        return User::whereType($userType)->inRandomOrder()->first();
    }

    protected function randomData(string $modelName, array $relation=[]): ?Model
    {
        switch ($modelName) {
            case OnlineRequest::class:
                return OnlineRequest::with($relation)->inRandomOrder()->limit(1)->get()->first();
                break;
            case User::class:
                return User::with($relation)->inRandomOrder()->limit(1)->get()->first();
                break;
            case Affair::class:
                return Affair::with($relation)->inRandomOrder()->limit(1)->get()->first();
                break;
            case FrequentlyAskedQuestion::class:
                return FrequentlyAskedQuestion::with($relation)->inRandomOrder()->limit(1)->get()->first();
                break;
            case OnlineRequestTracker::class:
                return OnlineRequestTracker::with($relation)->inRandomOrder()->limit(1)->get()->first();
                break;
            default:
                return null;
                break;

        }
    }

    protected function getAllData(string $modelName, array $with=[]): ?Collection
    {
        switch ($modelName) {
            case OnlineRequest::class:
                return OnlineRequest::with($with)->orderBy('name', 'asc')->get();
                break;
            default:
                return null;
                break;
        }
    }

}
