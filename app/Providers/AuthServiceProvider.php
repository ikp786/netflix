<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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
  /*  public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
    }*/

     public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        // Mandatory to define Scope
        Passport::tokensCan([
            'user' => 'Users',
            'driver' => 'Drivers',
            'admin' => 'Admins',
        ]);

        Passport::setDefaultScope([
            'user'
        ]);
    }
}
