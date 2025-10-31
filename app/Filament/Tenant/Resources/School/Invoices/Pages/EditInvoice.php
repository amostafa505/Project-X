<?php

namespace App\Filament\Tenant\Resources\School\Invoices\Pages;

use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Tenant\Resources\School\Invoices\InvoiceResource;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->can('invoices.update');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
