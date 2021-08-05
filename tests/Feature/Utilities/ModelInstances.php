<?php


namespace Tests\Feature\Utilities;


use App\Models\OnlineRequest;
use App\Models\User;

trait ModelInstances
{
    protected function getUser(string $userType): User
    {
        return User::whereType($userType)->inRandomOrder()->first();
    }

    protected function getModel(string $modelName): ?OnlineRequest
    {
        switch ($modelName) {
            case OnlineRequest::class:
                return OnlineRequest::inRandomOrder()->limit(1)->get()->first();
                break;
            default:
                return null;
                break;

        }
    }

}
