<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use App\Policies\OxygenRolePolicy;

use App\Role;

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

        Passport::routes();

        Gate::define('isSuperAdmin', function ($user) {
            return $user->role->admin === "CBL"
                ? Response::allow()
                : Response::deny('You must be a super administrator.');
        });

        Gate::define('isAdmin', function ($user) {
            try {
                return Role::where('admin', $user->role->admin)->exists();
            } catch (\Throwable $th) {
                return false;
            }
        });

        Gate::define('isLabAdmin', function ($user) {
            return $user->role->admin === "LAB"
                ? Response::allow()
                : Response::deny('You must be a lab administrator.');
        });

        Gate::define('isSuperOrLabAdmin', function ($user) {
            return $user->can('isSuperAdmin') || $user->can('isLabAdmin')
                ? Response::allow()
                : Response::deny('You must be a super or lab administrator.');
        });
        // Supervisor
        Gate::define('isSupervisor', function ($user) {
            return $user->role->admin === "SUPERVISOR"
                ? Response::allow()
                : Response::deny('You must be a supervisor.');
        });
        Gate::define('isProfiler', function ($user) {
            return $user->role->admin === "PROFILER"
                ? Response::allow()
                : Response::deny('You must be a profiler.');
        });
        Gate::define('isEkoCare', function ($user) {
            return $user->role->admin === "EKOCARE"
                ? Response::allow()
                : Response::deny('You must be an Eko Care.');
        });
        Gate::define('isLGA', function ($user) {
            return $user->role->admin === "LGA"
                ? Response::allow()
                : Response::deny('You must be a LGA.');
        });

        Gate::define('isMMIAAgent', function ($user) {
            return $user->role->admin === "MMIA AGENTS"
                ? Response::allow()
                : Response::deny('You must be a LGA.');
        });

        Gate::define('isNotMmiaAgents', function ($user) {
            return !$user->can('isMMIAAgent')
                ? Response::allow()
                : Response::deny('You must not be a Mmia Agent.');
        });

        Gate::define('isSuperAdminOrMmiaAgents', function ($user) {
            return $user->can('isSuperAdmin') || $user->can('isMMIAAgent')
                ? Response::allow()
                : Response::deny('You must be a super administrator.');
        });

        Gate::define('oxygen-admin', implode([OxygenRolePolicy::class, "@isAdmin"]));
    } //end method boot
}//end class AuthServiceProvider
