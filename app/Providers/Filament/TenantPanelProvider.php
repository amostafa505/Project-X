<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Filament\Panel;
use Filament\PanelProvider;
use App\Http\Middleware\EnsureUserBelongsToTenant;
use App\Http\Middleware\SetSpatieTeamFromTenant;
use App\Filament\Tenant\Pages\Stats;
use App\Filament\Tenant\Widgets\{
    FinanceOverview,
    SubjectsByBranchChart,
    RevenueThisMonthChart,
    RecentInvoices
};
use Spatie\Permission\PermissionRegistrar;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class TenantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('tenant')
            ->path('app')
            ->brandName('Project-X')
            ->login()
            // مهم: فعّل التينانسي أولاً ثم web
            ->middleware([
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
                'web',
                SetSpatieTeamFromTenant::class, // بيضبط TeamId للحزمة
            ])
            ->authMiddleware([
                FilamentAuthenticate::class,
                EnsureUserBelongsToTenant::class,
            ])
            ->discoverPages(
                in: app_path('Filament/Tenant/Pages'),
                for: 'App\\Filament\\Tenant\\Pages'
            )
            ->discoverResources(
                in: app_path('Filament/Tenant/Resources'),
                for: 'App\\Filament\\Tenant\\Resources'
            )
            ->homeUrl(fn () => Stats::getUrl())
            ->widgets([
                FinanceOverview::class,
                SubjectsByBranchChart::class,
                RevenueThisMonthChart::class,
                RecentInvoices::class,
            ])
            ->bootUsing(function () {
                // 👇 انقل أي استخدام لـ tenant() لجوه Filament::serving
                Filament::serving(function () {
                    // 1) Team-aware permissions
                    if (function_exists('tenant') && tenant()) {
                        app(PermissionRegistrar::class)->setPermissionsTeamId(tenant('id'));
                        config(['auth.defaults.guard' => 'web']);
                    }

                    // 2) تحميل الموارد حسب نوع التينانت
                    $type = tenant()?->type ?? 'school';

                    $map = [
                        'school' => [
                            \App\Filament\Tenant\Resources\StudentResource::class,
                            \App\Filament\Tenant\Resources\TeacherResource::class,
                            \App\Filament\Tenant\Resources\ClassroomResource::class,
                            \App\Filament\Tenant\Resources\SubjectResource::class,
                            \App\Filament\Tenant\Resources\EnrollmentResource::class,
                            \App\Filament\Tenant\Resources\InvoiceResource::class,
                            \App\Filament\Tenant\Resources\InvoiceItemResource::class,
                            \App\Filament\Tenant\Resources\FeeItemResource::class,
                            \App\Filament\Tenant\Resources\Attendance\AttendanceResource::class,
                            \App\Filament\Tenant\Resources\GuardianResource::class,
                            \App\Filament\Tenant\Resources\PaymentResource::class,
                        ],
                    ];

                    Filament::registerResources($map[$type] ?? $map['school']);

                    // 3) أي هوكس إضافية تعتمد على tenant()
                    $user = auth()->user();
                    if ($user && !$user->can('branches.viewAll')) {
                        // نفّذ سكوب/تصفية داخل الموارد نفسها
                    }

                    // (اختياري) للتشخيص:
                    logger()->info('tenant in serving: ' . (tenant()?->id ?? 'null'));
                });
            });
    }
}
