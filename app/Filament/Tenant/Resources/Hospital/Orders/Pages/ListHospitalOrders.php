<?php

namespace App\Filament\Tenant\Resources\Hospital\Order\Pages;

use App\Filament\Tenant\Resources\Hospital\Order\OrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrder extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
