<?php

namespace App\Filament\Central\Resources\Domains\Pages;

use App\Filament\Central\Resources\Domains\DomainResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDomain extends EditRecord
{
    protected static string $resource = DomainResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $host = strtolower(trim((string) ($data['domain'] ?? '')));
        if ($host !== '' && !str_contains($host, '.')) {
            $base = config('tenancy.base_domain') ?? (config('tenancy.central_domains')[0] ?? null);
            if ($base) {
                $host = $host . '.' . strtolower($base);
            }
        }
        $data['domain']     = $host;
        $data['is_primary'] = (bool) ($data['is_primary'] ?? false);
        return $data;
    }
}
