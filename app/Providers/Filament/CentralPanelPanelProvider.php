<?php
namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
// المهم: استخدم ميدلوير فيلمنت مش 'auth'
use Filament\Http\Middleware\Authenticate as FilamentAuthenticate;
// صفحة الداشبورد الجاهزة من فيلمنت
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
            ->middleware(['web'])                 // مفيش تنانسي هنا
            ->authMiddleware([FilamentAuthenticate::class])
            ->authGuard('web')                    // اختياري لكن مريح

            // خلي البانل يكتشف أي Resources/Pages للسنترال (لو هنعملها لاحقًا)
            ->discoverResources(in: app_path('Filament/Central/Resources'), for: 'App\\Filament\\Central\\Resources')
            ->discoverPages(in: app_path('Filament/Central/Pages'), for: 'App\\Filament\\Central\\Pages')

            // فعّل صفحة الداشبورد الجاهزة
            ->pages([ Dashboard::class ])

            // واجه الهوم لصفحة حقيقية علشان ما يحصلش redirect loop
            ->homeUrl(fn () => Dashboard::getUrl());
    }
}
