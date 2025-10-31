<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Spatie\Permission\PermissionRegistrar;


class EnsureCentralAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Filament::auth()->user();
        if (!$user) {
            return redirect()->route('filament.central.auth.login');
        }

        // ✅ ثبت team id المركزي قبل فحص الأدوار
        app(PermissionRegistrar::class)->setPermissionsTeamId('00000000-0000-0000-0000-000000000000');

        //the next lines for enable logger for the central panel
        logger()->info('User roles check', [
            'roles' => $user->getRoleNames(),
            'team_id' => app(\Spatie\Permission\PermissionRegistrar::class)->getPermissionsTeamId(),
        ]);
        // ⚠️ استخدم الاسم بالضبط كما في DB (عندك "Super Admin")
        if (!$user->hasRole('Super Admin')) {

            Filament::auth()->logout();
            return redirect()->route('filament.central.auth.login')
                ->with('danger', 'You are not allowed to access the central panel.');
        }

        return $next($request);
    }
}
