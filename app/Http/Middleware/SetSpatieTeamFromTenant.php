<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\PermissionRegistrar;

class SetSpatieTeamFromTenant
{
    public function handle($request, Closure $next)
    {
        if ($tenant = tenant()) {
            app(\Spatie\Permission\PermissionRegistrar::class)
                ->setPermissionsTeamId($tenant->id);
        }

        return $next($request);
    }
}
