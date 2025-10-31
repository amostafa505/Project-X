<?php

namespace App\Filament\Tenant\Resources\Appointments\Pages;

use App\Filament\Tenant\Resources\Appointments\AppointmentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointments extends CreateRecord
{
    protected static string $resource = AppointmentsResource::class;
}
