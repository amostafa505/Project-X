<?php

namespace App\Filament\Tenant\Resources\ClassRooms\Pages;

use App\Filament\Tenant\Resources\ClassRooms\ClassRoomResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClassRoom extends EditRecord
{
    protected static string $resource = ClassRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
