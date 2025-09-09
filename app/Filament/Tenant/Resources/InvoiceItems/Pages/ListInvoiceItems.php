<?php

namespace App\Filament\Tenant\Resources\InvoiceItems\Pages;

use App\Filament\Tenant\Resources\InvoiceItems\InvoiceItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInvoiceItems extends ListRecords
{
    protected static string $resource = InvoiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
