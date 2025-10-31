<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionsController;

/**
 * CENTRAL (no tenancy)
 */
Route::get('/', fn () => view('welcome'))->name('landing');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__ . '/auth.php';

/**
 * TENANT routes (domain or subdomain based)
 * Uses stancl middlewares + Spatie team sync.
 */
Route::middleware(['tenancy.init', 'tenancy.prevent', 'spatie.team'])
    ->group(function () {

        // Route::get('/dashboard', [DashboardController::class, 'index'])
        // ->name('dashboard');

        Route::resource('schools', SchoolsController::class)->except(['show']);
        Route::resource('branches', BranchesController::class)->except(['show']);
        // Route::resource('roles', RolesController::class)->except(['show']);
        // Route::resource('permissions', PermissionsController::class)->except(['show']);
        // Route::resource('users', UsersController::class)->except(['show']);

        // example tenant-only ping
        Route::get('/ping', fn () => 'pong (tenant=' . tenant()->id . ')');
    });
Route::get('/whoami', fn () => response()->json(['tenant' => tenant()?->id]))
    ->middleware(['web', \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class]);

Route::get('/locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'], true)) {
        setUserLocale($locale);
    }
    return back();
})->name('set-locale')->middleware(['web']);
