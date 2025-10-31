<?php

namespace App\Filament\Tenant\Resources\School\FeeItems\Pages;

use App\Filament\Tenant\Resources\School\FeeItems\FeeItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFeeItems extends ListRecords
{
    protected static string $resource = FeeItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
