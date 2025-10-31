<?php

namespace App\Filament\Tenant\Resources\Hospital\Appointments\Pages;

use App\Filament\Tenant\Resources\Hospital\Appointments\AppointmentsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAppointments extends EditRecord
{
    protected static string $resource = AppointmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
