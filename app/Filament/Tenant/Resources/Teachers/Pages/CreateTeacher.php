<?php

namespace App\Filament\Tenant\Resources\Teachers\Pages;

use App\Filament\Tenant\Resources\Teachers\TeacherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;
}
