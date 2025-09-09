<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\PermissionRegistrar;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            // ✨ افحص الدور على الفريق المركزي
            app(PermissionRegistrar::class)
                ->setPermissionsTeamId('00000000-0000-0000-0000-000000000000');

            return $user->hasRole('Super Admin') ? true : null;
        });
    }
}
