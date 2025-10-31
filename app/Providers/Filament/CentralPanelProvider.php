<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use App\Http\Middleware\EnsureCentralAccess;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;

class CentralPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('central')
            ->path('admin')
            ->brandName('Project-X (Central)')
            ->login()
            ->middleware(['web']) // مفيش Tenancy هنا
            ->authMiddleware([FilamentAuthenticate::class, EnsureCentralAccess::class])
            ->authGuard('web')
            ->discoverResources(in: app_path('Filament/Central/Resources'), for: 'App\\Filament\\Central\\Resources')
            ->discoverPages(in: app_path('Filament/Central/Pages'), for: 'App\\Filament\\Central\\Pages')
            ->pages([Dashboard::class])
            ->homeUrl(fn () => Dashboard::getUrl())
            ->widgets([
                // Central-only widgets فقط
            ]);
        //the next lines for enable logger on booting to central panel
        // ->bootUsing(function () {
        //     logger()->info('central panel booted on domain: ' . request()->getHost());
        // })

    }
}
