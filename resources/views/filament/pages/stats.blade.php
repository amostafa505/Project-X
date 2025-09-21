<x-filament::page>
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        {{-- احصائيات مالية سريعة --}}
        @livewire(\App\Filament\Tenant\Widgets\FinanceOverview::class)
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mt-6">
        {{-- شارت إيرادات الشهر الحالي --}}
        @livewire(\App\Filament\Tenant\Widgets\RevenueThisMonthChart::class)

        {{-- آخر 10 فواتير --}}
        @livewire(\App\Filament\Tenant\Widgets\RecentInvoices::class)
    </div>

    {{-- الويجتس القديمة اللي عندك --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mt-6">
        @livewire(\App\Filament\Tenant\Widgets\LatestBranchesTable::class)
        @livewire(\App\Filament\Tenant\Widgets\SubjectsByBranchChart::class)
    </div>
</x-filament::page>
