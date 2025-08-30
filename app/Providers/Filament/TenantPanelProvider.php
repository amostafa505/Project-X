<?php
namespace App\Providers\Filament;


use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use App\Filament\Tenant\Pages\Stats; // ← الصفحة اللي أنشأناها


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
        ->middleware(['web','tenancy.init','tenancy.prevent','spatie.team'])
        ->authMiddleware([FilamentAuthenticate::class])
        ->discoverResources(in: app_path('Filament/Tenant/Resources'), for: 'App\\Filament\\Tenant\\Resources')
        ->discoverPages(in: app_path('Filament/Tenant/Pages'), for: 'App\\Filament\\Tenant\\Pages')
        ->discoverWidgets(in: app_path('Filament/Tenant/Widgets'), for: 'App\\Filament\\Tenant\\Widgets')
        ->homeUrl(fn () => Stats::getUrl());
    }
}
