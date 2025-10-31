<?php

namespace App\Filament\Tenant\Resources\School\Subjects\Pages;

use App\Filament\Tenant\Resources\School\Subjects\SubjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubject extends CreateRecord
{
    protected static string $resource = SubjectResource::class;
}
