<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Branch;
use App\Models\School;
use App\Models\Subject;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TenantStatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $tenantId = function_exists('tenant') ? tenant('id') : null;

        $schools = School::when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))->count();
        $branches = Branch::when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))->count();
        $subjects = Subject::when($tenantId, fn ($q) => $q->where('tenant_id', $tenantId))->count();

        return [
            Stat::make('Schools', (string) $schools)->description('Total schools'),
            Stat::make('Branches', (string) $branches)->description('Total branches'),
            Stat::make('Subjects', (string) $subjects)->description('Total subjects'),
        ];
    }
}
