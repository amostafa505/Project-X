<?php
namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use App\Http\Middleware\EnsureCentralAccess;
use App\Filament\Tenant\Widgets\RecentInvoices;
use App\Filament\Tenant\Widgets\FinanceOverview;
use App\Filament\Tenant\Widgets\RevenueThisMonthChart;
use App\Filament\Tenant\Widgets\SubjectsByBranchChart;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;

class CentralPanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('central')
            ->path('admin')
            ->brandName('Project-X (Central)')
            ->login()
            ->middleware(['web'])
            ->authMiddleware([FilamentAuthenticate::class,EnsureCentralAccess::class])
            ->authGuard('web')
            ->discoverResources(in: app_path('Filament/Central/Resources'), for: 'App\\Filament\\Central\\Resources')
            ->discoverPages(in: app_path('Filament/Central/Pages'), for: 'App\\Filament\\Central\\Pages')
            ->pages([ Dashboard::class ])
            ->homeUrl(fn () => Dashboard::getUrl())
            ->widgets([
                FinanceOverview::class,
                SubjectsByBranchChart::class,
                RevenueThisMonthChart::class,
                RecentInvoices::class,
            ]);
    }
}
