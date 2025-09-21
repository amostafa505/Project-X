<?php

namespace App\Filament\Tenant\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Invoice;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RevenueThisMonthChart extends ChartWidget
{
    protected ?string $heading = 'Revenue (This Month)'; // ChartWidget::$heading non-static في إصدارك
    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $tenantId = tenant('id');
        $start = Carbon::now()->startOfMonth();
        $end   = Carbon::now()->endOfMonth();

        // إجمالي يومي حسب issue_date
        $rows = Invoice::query()
            ->where('tenant_id', $tenantId)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as d, SUM(amount) as s')
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        // نجهّز كل أيام الشهر بصفًر ثم ندمج النتائج
        $labels = [];
        $values = [];
        $cursor = $start->copy();
        $map = $rows->keyBy(fn ($r) => $r->d);

        while ($cursor->lte($end)) {
            $d = $cursor->toDateString();
            $labels[] = $cursor->format('d M');
            $values[] = (float) ($map[$d]->s ?? 0);
            $cursor->addDay();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'EGP',
                    'data'  => $values,
                    // ما نحددش ألوان — خليه بالافتراضي
                ],
            ],
        ];
    }
    public static function canView(): bool
    {
        return auth()->user()?->can('invoices.view') ?? false;
    }
}
