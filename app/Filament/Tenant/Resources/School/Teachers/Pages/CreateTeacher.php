<?php

namespace App\Filament\Tenant\Resources\School\Teachers\Pages;

use App\Filament\Tenant\Resources\School\Teachers\TeacherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;
}
