<?php

namespace App\Filament\Tenant\Resources\School\Guardians\Pages;

use App\Filament\Tenant\Resources\School\Guardians\GuardianResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGuardians extends ListRecords
{
    protected static string $resource = GuardianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
