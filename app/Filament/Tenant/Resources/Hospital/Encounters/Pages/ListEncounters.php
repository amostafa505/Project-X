<?php

namespace App\Filament\Tenant\Resources\Hospital\Encounters\Pages;

use App\Filament\Tenant\Resources\Hospital\Encounters\EncountersResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEncounters extends ListRecords
{
    protected static string $resource = EncountersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
