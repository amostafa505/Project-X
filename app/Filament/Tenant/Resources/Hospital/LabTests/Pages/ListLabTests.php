<?php

namespace App\Filament\Tenant\Resources\Hospital\LabTests\Pages;

use App\Filament\Tenant\Resources\Hospital\LabTests\LabTestsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLabTests extends ListRecords
{
    protected static string $resource = LabTestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
