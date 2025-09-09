<?php

namespace App\Providers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Observers\InvoiceObserver;
use Illuminate\Support\Facades\Gate;
use App\Observers\InvoiceItemObserver;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\EnsureCentralAccess;
use App\Http\Middleware\SetSpatieTeamFromTenant;
use Illuminate\Foundation\Http\Kernel as Kernel;
use App\Http\Middleware\EnsureUserBelongsToTenant;
use Illuminate\Routing\Middleware\SubstituteBindings;

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
              EnsureUserBelongsToTenant::class,
              EnsureCentralAccess::class,
          );

        Invoice::observe(InvoiceObserver::class);
        InvoiceItem::observe(InvoiceItemObserver::class);
        Gate::policy(Invoice::class, InvoicePolicy::class);
        Gate::policy(InvoiceItem::class, InvoiceItemPolicy::class);
    }
}
