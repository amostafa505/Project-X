<?php

namespace App\Filament\Tenant\Resources\Patients\Pages;

use App\Filament\Tenant\Resources\Patients\PatientsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPatients extends ListRecords
{
    protected static string $resource = PatientsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
