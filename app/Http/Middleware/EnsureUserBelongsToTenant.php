<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\TenantUser;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Spatie\Permission\PermissionRegistrar;

class EnsureUserBelongsToTenant
{
    public function handle(Request $request, Closure $next)
    {
        $auth = Filament::auth();
        $user = $auth->user();

        if (! $user) {
            return redirect()->route('filament.tenant.auth.login');
        }

        $tenantId = tenant('id');
        if (! $tenantId) {
            abort(404, 'Tenant not identified');
        }

        // 1) ✨ لو المستخدم Super Admin على الفريق المركزي → اسمح له يعدي
        $centralTeam = '00000000-0000-0000-0000-000000000000';

        // افحص الدور على الفريق المركزي صراحةً
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($centralTeam);
        $isCentralSuperAdmin = $user->hasRole('Super Admin'); // الاسم يطابق الجدول

        if (! $isCentralSuperAdmin) {
            // 2) غير كده لازم يكون عضو في التينانت
            $isMember = TenantUser::query()
                ->where('tenant_id', $tenantId)
                ->where('user_id', $user->getKey())
                ->exists();

            if (! $isMember) {
                Filament::auth()->logout();
                return redirect()->route('filament.tenant.auth.login')
                    ->with('danger', 'You are not allowed to access the Tenant panel.');
            }
        }

        // 3) في جميع الأحوال—ثبّت team id لسياق التينانت الحالي
        app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($tenantId);

        return $next($request);
    }
    // public function handle(Request $request, Closure $next)
    // {
    //     $auth = Filament::auth();
    //     $user = $auth->user();
    //     // لو مش لوجد إن
    //     if (! auth()->check()) {
    //         return redirect()->route('filament.tenant.auth.login'); // عدّل المسار حسب لوحتك
    //     }

    //     $tenantId = tenant('id'); // Stancl Tenancy
    //     if (! $tenantId) {
    //         abort(404, 'Tenant not identified');
    //     }

    //     $exists = TenantUser::query()
    //         ->where('tenant_id', $tenantId)
    //         ->where('user_id', auth()->id())
    //         ->exists();

    //     if (! $exists) {

    //     }

    //     // ثبّت team id لسبايتى RBAC
    //     app(PermissionRegistrar::class)->setPermissionsTeamId($tenantId);

    //     // 1) ✨ لو المستخدم Super Admin على الفريق المركزي → اسمح له يعدي
    //     $centralTeam = '00000000-0000-0000-0000-000000000000';

    //     // افحص الدور على الفريق المركزي صراحةً
    //     app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($centralTeam);
    //     $isCentralSuperAdmin = $user->hasRole('Super Admin'); // الاسم يطابق الجدول

    //     if (! $isCentralSuperAdmin) {
    //         // 2) غير كده لازم يكون عضو في التينانت
    //         $isMember = TenantUser::query()
    //             ->where('tenant_id', $tenantId)
    //             ->where('user_id', $user->getKey())
    //             ->exists();

    //         if (! $isMember) {
    //             Filament::auth()->logout();
    //             return redirect()->route('filament.tenant.auth.login')
    //                 ->with('danger', 'You are not allowed to access the Tenant panel.');
    //         }
    //     }

    //             // 3) في جميع الأحوال—ثبّت team id لسياق التينانت الحالي
    //             app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId($tenantId);

    //     return $next($request);
    // }
}
