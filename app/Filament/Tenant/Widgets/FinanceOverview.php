<?php

namespace App\Filament\Tenant\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

class FinanceOverview extends BaseWidget
{
    // في إصدارك: $heading شغّالة non-static (سيبها كده طالما مفيش خطأ عليها)
    protected ?string $heading = 'Finance (This Month)';

    // ❌ كانت non-static
    // protected ?int $sort = 1;
    // ✅ خليه STATIC ليتوافق مع Widget::$sort
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $tenantId = tenant('id');
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        $base = Invoice::query()->where('tenant_id', $tenantId);

        $paid = (clone $base)->whereBetween('issue_date', [$start, $end])
            ->where('status', 'paid')
            ->sum('total');

        $due = (clone $base)->whereBetween('issue_date', [$start, $end])
            ->whereIn('status', ['pending', 'unpaid'])
            ->sum('total');

        $overdue = (clone $base)->where('due_date', '<', Carbon::today())
            ->whereIn('status', ['pending', 'unpaid'])
            ->sum('total');

        return [
            Stat::make('Paid (This Month)', number_format((float) $paid, 2) . ' EGP'),
            Stat::make('Due (This Month)', number_format((float) $due, 2) . ' EGP'),
            Stat::make('Overdue', number_format((float) $overdue, 2) . ' EGP'),
        ];
    }
}
