<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $tenant = function_exists('tenant') ? tenant() : null;

        $locale = auth()->user()->locale
            ?? session('locale')
            ?? config('app.locale');

        app()->setLocale($locale);
        Carbon::setLocale($locale);

        // RTL for Filament when Arabic
        config(['filament.layout.direction' => in_array($locale, ['ar', 'fa', 'ur']) ? 'rtl' : 'ltr']);

        function money_format_locale($amount, $currency = 'EGP', $locale = null)
        {
            $locale ??= app()->getLocale();
            $fmt = new \NumberFormatter($locale . '_EG', \NumberFormatter::CURRENCY);
            return $fmt->formatCurrency($amount, $currency);
        }

        return $next($request);
    }
}
