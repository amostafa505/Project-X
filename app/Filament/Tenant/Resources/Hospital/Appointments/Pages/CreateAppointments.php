<?php

namespace App\Filament\Tenant\Resources\Hospital\Appointments\Pages;

use App\Filament\Tenant\Resources\Hospital\Appointments\AppointmentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointments extends CreateRecord
{
    protected static string $resource = AppointmentsResource::class;
}
