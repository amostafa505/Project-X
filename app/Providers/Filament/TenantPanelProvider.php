<?php
namespace App\Providers\Filament;


use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use App\Filament\Tenant\Pages\Stats; // ← الصفحة اللي أنشأناها
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\SetSpatieTeamFromTenant;



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
        ->authMiddleware([FilamentAuthenticate::class])
        ->discoverPages(in: app_path('Filament/Tenant/Pages'), for: 'App\\Filament\\Tenant\\Pages')
        ->discoverResources(in: app_path('Filament/Tenant/Resources'), for: 'App\\Filament\\Tenant\\Resources')
        ->homeUrl(fn () => Stats::getUrl());
    }
}
