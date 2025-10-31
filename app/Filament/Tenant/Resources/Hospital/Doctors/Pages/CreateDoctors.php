<?php

namespace App\Filament\Tenant\Resources\Hospital\Doctors\Pages;

use App\Filament\Tenant\Resources\Hospital\Doctors\DoctorsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctors extends CreateRecord
{
    protected static string $resource = DoctorsResource::class;
}
