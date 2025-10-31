<?php

namespace App\Filament\Tenant\Resources\School\Enrollments\Pages;

use App\Filament\Tenant\Resources\School\Enrollments\EnrollmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;
}
