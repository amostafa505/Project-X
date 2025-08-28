<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\PermissionRegistrar;

class SetSpatieTeamFromTenant
{
    public function handle($request, Closure $next)
    {
        if (function_exists('tenant') && tenant()) {
            app(PermissionRegistrar::class)->setPermissionsTeamId(tenant()->id);
        }
        return $next($request);
    }
}
