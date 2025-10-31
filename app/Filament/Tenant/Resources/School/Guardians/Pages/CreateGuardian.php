<?php

namespace App\Filament\Tenant\Resources\School\Guardians\Pages;

use App\Filament\Tenant\Resources\School\Guardians\GuardianResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGuardian extends CreateRecord
{
    protected static string $resource = GuardianResource::class;
}
