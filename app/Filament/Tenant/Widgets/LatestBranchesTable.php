<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Branch;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestBranchesTable extends BaseWidget
{
    protected static ?string $heading = 'Latest Branches';

    protected function getTableQuery(): Builder
    {
        $tenantId = function_exists('tenant') ? tenant('id') : null;

        return Branch::query()
            ->when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('code')->badge()->sortable(),
            Tables\Columns\TextColumn::make('school.name')->label('School'),
            Tables\Columns\TextColumn::make('created_at')->since()->sortable(),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->can('invoices.view') ?? false;
    }
}
