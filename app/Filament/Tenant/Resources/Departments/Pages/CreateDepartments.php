<?php

namespace App\Filament\Tenant\Resources\Departments\Pages;

use App\Filament\Tenant\Resources\Departments\DepartmentsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartments extends CreateRecord
{
    protected static string $resource = DepartmentsResource::class;
}
