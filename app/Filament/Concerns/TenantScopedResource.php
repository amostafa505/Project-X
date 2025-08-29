<?php
namespace App\Filament\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait TenantScopedResource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (function_exists('tenant') && tenant('id')) {
            $query->where('tenant_id', tenant('id'));
        }
        return $query;
    }
}
