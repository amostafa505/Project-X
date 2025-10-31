<?php

namespace App\Filament\Tenant\Resources\Hospital\Departments\Pages;

use App\Filament\Tenant\Resources\Hospital\Departments\DepartmentsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
