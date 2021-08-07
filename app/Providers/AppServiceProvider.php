<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * validator to never include unvalidated array keys in the "validated"
         * data it returns, even if you use the array rule without specifying
         * a list of allowed keys.
         */
        Validator::excludeUnvalidatedArrayKeys();
    }
}
