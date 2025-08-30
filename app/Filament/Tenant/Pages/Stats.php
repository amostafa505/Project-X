<?php

namespace App\Filament\Tenant\Pages;

use Filament\Pages\Page;

class Stats extends Page
{
    // أيقونة كسترينج عشان المضمون
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    // v4: string غير قابل لـ null + غير static
    protected string $view = 'filament.tenant.pages.stats';

    // اختياري
    protected ?string $heading = 'Dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
}
