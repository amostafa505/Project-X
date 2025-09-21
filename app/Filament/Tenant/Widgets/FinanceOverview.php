<?php

namespace App\Filament\Tenant\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

class FinanceOverview extends BaseWidget
{
    protected ?string $heading = 'Finance (This Month)';

    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('invoices.view') ?? false;
    }

    protected function getStats(): array
    {
        $tenantId = tenant('id');
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        $base = Invoice::query()->where('tenant_id', $tenantId);

        $paid = (clone $base)->whereBetween('created_at', [$start, $end])
            ->where('status', 'paid')
            ->sum('amount');

        $due = (clone $base)->whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['pending', 'unpaid'])
            ->sum('amount');

        $overdue = (clone $base)->where('due_date', '<', Carbon::today())
            ->whereIn('status', ['pending', 'unpaid'])
            ->sum('amount');

        return [
            Stat::make('Paid (This Month)', number_format((float) $paid, 2) . ' EGP'),
            Stat::make('Due (This Month)', number_format((float) $due, 2) . ' EGP'),
            Stat::make('Overdue', number_format((float) $overdue, 2) . ' EGP'),
        ];
    }
}
