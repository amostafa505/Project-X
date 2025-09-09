<?php

namespace App\Filament\Tenant\Resources\Guardians\Pages;

use App\Filament\Tenant\Resources\Guardians\GuardianResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGuardian extends CreateRecord
{
    protected static string $resource = GuardianResource::class;
}
