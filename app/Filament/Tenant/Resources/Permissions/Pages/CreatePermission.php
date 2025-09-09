<?php

namespace App\Filament\Tenant\Resources\Permissions\Pages;

use App\Filament\Tenant\Resources\Permissions\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
}
