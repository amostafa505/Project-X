<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('centralTenantId')) {
    function centralTenantId(): string
    {
        return config('app.central_tenant_id');
    }
}

if (!function_exists('setUserLocale')) {
    function setUserLocale(string $locale): void
    {
        // خزّن في السيشن علشان يشتغل حتى قبل/بعد اللوجين
        session(['locale' => $locale]);

        // لو فيه يوزر، خزّنها في قاعدة البيانات (لو عندك عمود locale على users)
        if (Auth::check()) {
            Auth::user()->forceFill(['locale' => $locale])->save();
        }

        // فعّل اللغة للريكوست الحالي
        app()->setLocale($locale);
    }
}
