<?php

namespace App\Providers;

use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::before(function (User $user) {
            if ($user->role->name === 'admin') {
                return true;
            }
        });

        Gate::define('manage-products', function (User $user) {
            if ($user->role->name === 'admin') {
                return true;
            }
        });

        Gate::define('edit-user', function (User $auth, ?User $user) {
            if ($auth->id === optional($user)->id) {
                return true;
            }
        });

        $this->registerPolicies();
    }
}
