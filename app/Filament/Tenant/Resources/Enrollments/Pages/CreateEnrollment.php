<?php

namespace App\Filament\Tenant\Resources\Enrollments\Pages;

use App\Filament\Tenant\Resources\Enrollments\EnrollmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;
}
