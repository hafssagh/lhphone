<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define("admin", function(User $user){
            return $user->hasRole("Administrateur");
        });

        Gate::define("manager", function(User $user){
            return $user->hasRole("Manager");
        });

        Gate::define("agent", function(User $user){
            return $user->hasRole("Agent");
        });

        Gate::define("superadmin", function(User $user){
            return $user->hasRole("Super Administrateur");
        });

        Gate::after(function (User $user) {
           return $user->hasRole("superadmin");
        });
    }
}
