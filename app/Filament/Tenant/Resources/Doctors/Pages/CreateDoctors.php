<?php

namespace App\Filament\Tenant\Resources\Doctors\Pages;

use App\Filament\Tenant\Resources\Doctors\DoctorsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctors extends CreateRecord
{
    protected static string $resource = DoctorsResource::class;
}
