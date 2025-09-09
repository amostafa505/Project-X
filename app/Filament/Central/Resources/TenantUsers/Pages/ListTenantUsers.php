<?php

namespace App\Filament\Central\Resources\TenantUsers\Pages;

use App\Filament\Central\Resources\TenantUsers\TenantUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenantUsers extends ListRecords
{
    protected static string $resource = TenantUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
