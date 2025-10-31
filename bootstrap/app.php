<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\SetSpatieTeamFromTenant;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            base_path('routes/web.php'),      // لو مش بتستعمله سيبه فاضي
            base_path('routes/central.php'),  // راوتس السنترال (بدون تننسي)
            base_path('routes/tenant.php'),   // راوتس التينانت (بميدل وير الستانسل)
        ],
        commands: base_path('routes/console.php'),
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            // stancl tenancy
            'tenancy.init'   => InitializeTenancyByDomain::class,
            'tenancy.prevent' => PreventAccessFromCentralDomains::class,
            // spatie teams sync
            'spatie.team'    => SetSpatieTeamFromTenant::class,
            'setlocale' => SetLocale::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })->create();
