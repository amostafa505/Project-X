<?php

namespace App\Filament\Tenant\Resources\Hospital\Order\Pages;

use App\Filament\Tenant\Resources\Hospital\Order\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
