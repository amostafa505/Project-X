<?php

namespace App\Filament\Tenant\Resources\Patients\Pages;

use App\Filament\Tenant\Resources\Patients\PatientsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPatients extends EditRecord
{
    protected static string $resource = PatientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
