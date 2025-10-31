<?php

namespace App\Filament\Tenant\Resources\Patients\Pages;

use App\Filament\Tenant\Resources\Patients\PatientsResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePatients extends CreateRecord
{
    protected static string $resource = PatientsResource::class;
}
