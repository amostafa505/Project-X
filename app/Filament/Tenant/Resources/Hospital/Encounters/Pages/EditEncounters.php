<?php

namespace App\Filament\Tenant\Resources\Hospital\Encounters\Pages;

use App\Filament\Tenant\Resources\Hospital\Encounters\EncountersResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEncounters extends EditRecord
{
    protected static string $resource = EncountersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
