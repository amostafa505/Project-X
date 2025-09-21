<?php
namespace App\Providers\Filament;


use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Tenant\Widgets\RecentInvoices;
use App\Filament\Tenant\Widgets\FinanceOverview;
use App\Http\Middleware\SetSpatieTeamFromTenant;
use App\Http\Middleware\EnsureUserBelongsToTenant;
use App\Filament\Tenant\Widgets\RevenueThisMonthChart;
use App\Filament\Tenant\Widgets\SubjectsByBranchChart;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Filament\Tenant\Pages\Stats; // ← الصفحة اللي أنشأناها
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;



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
        ->middleware(['web', InitializeTenancyByDomain::class,PreventAccessFromCentralDomains::class,SetSpatieTeamFromTenant::class])
        ->authMiddleware([FilamentAuthenticate::class,EnsureUserBelongsToTenant::class])
        ->discoverPages(in: app_path('Filament/Tenant/Pages'), for: 'App\\Filament\\Tenant\\Pages')
        ->discoverResources(in: app_path('Filament/Tenant/Resources'), for: 'App\\Filament\\Tenant\\Resources')
        ->homeUrl(fn () => Stats::getUrl())
        ->widgets([
            FinanceOverview::class,
            SubjectsByBranchChart::class,
            RevenueThisMonthChart::class,
            RecentInvoices::class,
        ]);

    }
}
