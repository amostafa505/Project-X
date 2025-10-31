<?php

namespace App\Filament\Tenant\Resources\School\FeeItems\Pages;

use App\Filament\Tenant\Resources\School\FeeItems\FeeItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFeeItem extends EditRecord
{
    protected static string $resource = FeeItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
