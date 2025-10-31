<?php

namespace App\Filament\Tenant\Resources\School\InvoiceItems\Pages;

use App\Models\FeeItem;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Tenant\Resources\School\InvoiceItems\InvoiceItemResource;

class EditInvoiceItem extends EditRecord
{
    protected static string $resource = InvoiceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['item']) && !empty($data['fee_item_id'])) {
            $data['item'] = FeeItem::find($data['fee_item_id'])?->name;
        }

        $data['tenant_id'] = tenant('id');
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
