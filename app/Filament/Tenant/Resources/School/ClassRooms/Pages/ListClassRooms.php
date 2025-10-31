<?php

namespace App\Filament\Tenant\Resources\School\ClassRooms\Pages;

use App\Filament\Tenant\Resources\School\ClassRooms\ClassRoomResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClassRooms extends ListRecords
{
    protected static string $resource = ClassRoomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
