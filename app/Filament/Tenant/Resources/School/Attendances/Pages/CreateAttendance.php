<?php

namespace App\Filament\Tenant\Resources\School\Attendances\Pages;

use App\Filament\Tenant\Resources\School\Attendances\AttendanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;
}
