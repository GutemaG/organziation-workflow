<?php


namespace Tests\Feature\Utilities;


use App\Models\OnlineRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ModelInstances
{
    protected function getUser(string $userType): User
    {
        return User::whereType($userType)->inRandomOrder()->first();
    }

    protected function randomData(string $modelName): ?Model
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

    protected function getAllData(string $modelName): ?Collection
    {
        switch ($modelName) {
            case OnlineRequest::class:
                return OnlineRequest::orderBy('name', 'asc')->get();
                break;
            default:
                return null;
                break;
        }
    }

}
