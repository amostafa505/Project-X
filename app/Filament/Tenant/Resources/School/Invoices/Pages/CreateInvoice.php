<?php

namespace App\Filament\Tenant\Resources\School\Invoices\Pages;

use App\Filament\Tenant\Resources\School\Invoices\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
    public static function canCreate(): bool
    {
        return auth()->user()->can('invoices.create');
    }
}
