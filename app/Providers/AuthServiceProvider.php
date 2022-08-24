<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::before(function ($user, $ability) {
            if ($user->email == 'admin@gmail.com') {
                return true;
            }
        });
        Gate::define('user-update', function (User $user) {
            if (!$user->permissions()->where('permission_id', 2)->get()->isEmpty()) return Response::allow();
            return Response::deny('Вам нельзя обновлять пользователей');
        });

        Gate::define('user-delete', function (User $user) {
            if (!$user->permissions()->where('permission_id', 3)->get()->isEmpty()) return Response::allow();
            return Response::deny('Вам нельзя удалять пользователей');
        });
        Gate::define('user-create', function (User $user) {
            if (!$user->permissions()->where('permission_id', 1)->get()->isEmpty()) return Response::allow();
            return Response::deny('Вам нельзя создавать пользователей');
        });
    }
}
