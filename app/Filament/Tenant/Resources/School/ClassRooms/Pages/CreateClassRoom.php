<?php

namespace App\Filament\Tenant\Resources\School\ClassRooms\Pages;

use App\Filament\Tenant\Resources\School\ClassRooms\ClassRoomResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClassRoom extends CreateRecord
{
    protected static string $resource = ClassRoomResource::class;
}
