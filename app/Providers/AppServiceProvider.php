<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Kernel as Kernel;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\SetSpatieTeamFromTenant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          /** @var Kernel $kernel */
          $kernel = app()->make(Kernel::class);

          $kernel->addToMiddlewarePriorityBefore(
              SetSpatieTeamFromTenant::class,
              SubstituteBindings::class,
          );
    }
}
