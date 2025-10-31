<?php

namespace App\Filament\Tenant\Resources\School\Guardians\Pages;

use App\Filament\Tenant\Resources\School\Guardians\GuardianResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGuardian extends EditRecord
{
    protected static string $resource = GuardianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
