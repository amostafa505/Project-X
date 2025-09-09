<?php

namespace App\Filament\Central\Resources\TenantUsers\Pages;

use App\Filament\Central\Resources\TenantUsers\TenantUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenantUser extends CreateRecord
{
    protected static string $resource = TenantUserResource::class;
}
