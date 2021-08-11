<?php

namespace App\Providers;

use App\Http\Controllers\Utilities\UserType;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin', function ($user){
            return $user->type == UserType::admin();
        });

        Gate::define('is-it-team-member', function ($user){
            return $user->type == UserType::itTeam();
        });

        Gate::define('is-staff', function ($user){
            return $user->type == UserType::staff();
        });

        Gate::define('is-reception', function ($user){
            return $user->type == UserType::reception();
        });
    }
}
