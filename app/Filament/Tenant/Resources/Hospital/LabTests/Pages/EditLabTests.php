<?php

namespace App\Filament\Tenant\Resources\Hospital\LabTests\Pages;

use App\Filament\Tenant\Resources\Hospital\LabTests\LabTestsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLabTests extends EditRecord
{
    protected static string $resource = LabTestsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
