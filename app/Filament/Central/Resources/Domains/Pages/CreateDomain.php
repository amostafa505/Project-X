<?php

namespace App\Filament\Central\Resources\Domains\Pages;

use App\Filament\Central\Resources\Domains\DomainResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDomain extends CreateRecord
{
    protected static string $resource = DomainResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $host = strtolower(trim((string) ($data['domain'] ?? '')));

        // لو المستخدم كتب label بس، كمّله بقاعدة الدومين
        if ($host !== '' && !str_contains($host, '.')) {
            $base = config('tenancy.base_domain') ?? (config('tenancy.central_domains')[0] ?? null);
            if ($base) {
                $host = $host . '.' . strtolower($base);
            }
        }

        $data['domain']     = $host;                  // لا ترجع فاضي
        $data['is_primary'] = (bool) ($data['is_primary'] ?? false);

        return $data;
    }
}
