<?php

namespace App\Filament\Tenant\Resources\Hospital\Doctors\Pages;

use App\Filament\Tenant\Resources\Hospital\Doctors\DoctorsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDoctors extends ListRecords
{
    protected static string $resource = DoctorsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
