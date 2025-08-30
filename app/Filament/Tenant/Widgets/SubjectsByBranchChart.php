<?php


namespace App\Filament\Tenant\Widgets;


use App\Models\Branch;
use Filament\Widgets\ChartWidget;


class SubjectsByBranchChart extends ChartWidget
{
protected static ?string $heading = 'Subjects by Branch';


protected function getData(): array
{
$tenantId = function_exists('tenant') ? tenant('id') : null;


$branches = Branch::when($tenantId, fn($q)=>$q->where('tenant_id', $tenantId))
->withCount('subjects')
->latest()
->take(6)
->get();


return [
'datasets' => [[
'label' => 'Subjects',
'data' => $branches->pluck('subjects_count')->toArray(),
]],
'labels' => $branches->pluck('name')->toArray(),
];
}


protected function getType(): string
{
return 'bar';
}
}
