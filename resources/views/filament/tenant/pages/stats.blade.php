<x-filament::page>
    <div class="prose">
        <h2>Welcome 👋</h2>
        <p>This is the tenant dashboard placeholder.</p>
    </div>
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        @livewire(\App\Filament\Tenant\Widgets\TenantStatsOverview::class)
    </div>


    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mt-6">
        @livewire(\App\Filament\Tenant\Widgets\LatestBranchesTable::class)
        @livewire(\App\Filament\Tenant\Widgets\SubjectsByBranchChart::class)
    </div>
</x-filament::page>
