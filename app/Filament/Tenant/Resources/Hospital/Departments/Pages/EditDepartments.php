<?php

namespace App\Filament\Tenant\Resources\Hospital\Departments\Pages;

use App\Filament\Tenant\Resources\Hospital\Departments\DepartmentsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditDepartments extends EditRecord
{
    protected static string $resource = DepartmentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
