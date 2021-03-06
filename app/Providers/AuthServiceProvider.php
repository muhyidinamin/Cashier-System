<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function($user){
        // TODO: logika untuk mengizinkan manage users
            return count(array_intersect(["ADMIN"], json_decode($user->roles)));
        });
        Gate::define('manage-categories', function($user){
        // TODO: logika untuk mengizinkan manage categories
            return count(array_intersect(["ADMIN"], json_decode($user->roles)));
        });
        Gate::define('manage-foods', function($user){
        // TODO: logika untuk mengizinkan manage foods
            return count(array_intersect(["ADMIN", "CASHIER", "WAITER"], json_decode($user->roles)));
        });
        Gate::define('manage-orders', function($user){
        // TODO: logika untuk mengizinkan manage orders
            return count(array_intersect(["ADMIN", "CASHIER", "WAITER"], json_decode($user->roles)));
        });
        Gate::define('print-report', function($user){
        // TODO: logika untuk mengizinkan manage orders
            return count(array_intersect(["ADMIN", "WAITER"], json_decode($user->roles)));
        });
    }
}
