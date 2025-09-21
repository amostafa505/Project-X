<?php
// routes/central.php
use Illuminate\Support\Facades\Route;

Route::middleware('web')
    ->domain(config('tenancy.central_domains.0')) // مثال: central.project-x.test
    ->group(function () {
        Route::get('/', fn () => 'Central app (no tenancy).');
        // هنا الـ CentralPanel بتاع Filament، صفحات إدارة tenants, orgs, plans...
    });
