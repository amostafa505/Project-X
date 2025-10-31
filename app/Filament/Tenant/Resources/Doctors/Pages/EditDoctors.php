<?php

namespace App\Filament\Tenant\Resources\Doctors\Pages;

use App\Filament\Tenant\Resources\Doctors\DoctorsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctors extends EditRecord
{
    protected static string $resource = DoctorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
