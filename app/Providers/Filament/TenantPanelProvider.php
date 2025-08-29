<?php
namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;


class TenantPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('tenant')
            ->path('app') // خليه غير /dashboard لتجنب التعارض
            ->brandName('Project-X')
            ->login()
            ->middleware(['web','tenancy.init','tenancy.prevent','spatie.team'])
            ->homeUrl('/app/branches')
            ->authMiddleware([\Filament\Http\Middleware\Authenticate::class]);

    }
}
