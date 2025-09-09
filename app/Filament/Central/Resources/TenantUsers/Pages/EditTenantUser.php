<?php

namespace App\Filament\Central\Resources\TenantUsers\Pages;

use App\Filament\Central\Resources\TenantUsers\TenantUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTenantUser extends EditRecord
{
    protected static string $resource = TenantUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
