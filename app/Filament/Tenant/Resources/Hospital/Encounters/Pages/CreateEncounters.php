<?php

namespace App\Filament\Tenant\Resources\Hospital\Encounters\Pages;

use App\Filament\Tenant\Resources\Hospital\Encounters\EncountersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEncounters extends CreateRecord
{
    protected static string $resource = EncountersResource::class;
}
