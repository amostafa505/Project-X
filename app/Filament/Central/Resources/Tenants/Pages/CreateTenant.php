<?php

namespace App\Filament\Central\Resources\Tenants\Pages;

use App\Filament\Central\Resources\Tenants\TenantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code']     = strtoupper(trim($data['code'] ?? ''));
        $data['currency'] = strtoupper(trim($data['currency'] ?? 'EGP'));
        $data['locale']   = $data['locale']   ?? 'ar';
        $data['timezone'] = $data['timezone'] ?? 'Africa/Cairo';
        $data['plan']     = $data['plan']     ?? 'free';
        $data['status']   = $data['status']   ?? 'active';

        // تأكد إن JSONs مش null
        $data['data'] = $data['data'] ?? [];
        $data['meta'] = $data['meta'] ?? [];

        return $data;
    }
}
