<?php
namespace App\Providers\Filament;

use App\Http\Middleware\EnsureCentralAccess;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
use Filament\Pages\Dashboard;

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
            ->homeUrl(fn () => Dashboard::getUrl());
    }
}
