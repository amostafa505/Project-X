<?php

namespace App\Filament\Tenant\Resources\Students\Pages;

use App\Filament\Tenant\Resources\Students\StudentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;
}
