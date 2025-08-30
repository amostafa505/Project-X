<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
// لو ولّدت BranchResource في بانل tenant:
use App\Filament\Pages\Stats;
// اختيارى: لو هتستعمل Dashboard
use Filament\Pages\Dashboard;
use App\Filament\Resources\Branches\BranchResource;

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
            ->authMiddleware(['auth'])

            // مهم: خليه يكتشف الريسورسز الخاصة ببانل التينانت
            ->discoverResources(
                in: app_path('Filament/Tenant/Resources'),
                for: 'App\\Filament\\Tenant\\Resources',
            )

            // اختياري: لو عندك Dashboard جاهزة
            //->pages([ Dashboard::class ])

            // مهم: وجّه الهوم لصفحة لها URL حقيقي
            ->pages([ \App\Filament\Tenant\Pages\Stats::class ])
            // ->homeUrl(fn () => BranchResource::getUrl());
            ->homeUrl(fn () => Stats::getUrl());
    }
}
