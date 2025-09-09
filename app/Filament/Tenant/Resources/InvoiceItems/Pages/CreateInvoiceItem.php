<?php

namespace App\Filament\Tenant\Resources\InvoiceItems\Pages;

use App\Models\FeeItem;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Tenant\Resources\InvoiceItems\InvoiceItemResource;

class CreateInvoiceItem extends CreateRecord
{
    protected static string $resource = InvoiceItemResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['item']) && !empty($data['fee_item_id'])) {
            $data['item'] = FeeItem::find($data['fee_item_id'])?->name;
        }

        $data['line_total'] = round(($data['qty'] ?? 0) * ($data['unit_price'] ?? 0), 2);

        return $data;
    }

protected function mutateFormDataBeforeSave(array $data): array
{
    if (empty($data['item']) && !empty($data['fee_item_id'])) {
        $data['item'] = FeeItem::find($data['fee_item_id'])?->name;
    }

    $data['line_total'] = round(($data['qty'] ?? 0) * ($data['unit_price'] ?? 0), 2);

    return $data;
}
}
