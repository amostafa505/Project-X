<?php

namespace App\Observers;

use App\Models\InvoiceItem;

class InvoiceItemObserver
{
    /**
     * Handle the InvoiceItem "created" event.
     */
    public function created(InvoiceItem $invoiceItem): void
    {
        $invoiceItem->total = ($invoiceItem->qty ?? 1) * ($invoiceItem->unit_price ?? 0);
    }

    /**
     * Handle the InvoiceItem "updated" event.
     */
    public function updated(InvoiceItem $invoiceItem): void
    {
        $invoiceItem->total = ($invoiceItem->qty ?? 1) * ($invoiceItem->unit_price ?? 0);

    }

    public function saved(InvoiceItem $invoiceItem): void
    {
        $this->recalcInvoice($invoiceItem);
    }

    /**
     * Handle the InvoiceItem "deleted" event.
     */
    public function deleted(InvoiceItem $invoiceItem): void
    {
        $this->recalcInvoice($invoiceItem);
    }

    /**
     * Handle the InvoiceItem "restored" event.
     */
    public function restored(InvoiceItem $invoiceItem): void
    {
        //
    }

    /**
     * Handle the InvoiceItem "force deleted" event.
     */
    public function forceDeleted(InvoiceItem $invoiceItem): void
    {
        //
    }

    protected function recalcInvoice(InvoiceItem $item): void
    {
        // اعمل refresh لعلاقة الفاتورة لو مش محمّلة
        if (! $item->relationLoaded('invoice')) {
            $item->load('invoice');
        }

        $invoice = $item->invoice;
        if (! $invoice) {
            return;
        }

        $sum = $invoice->items()->sum('total'); // غيّر items لو علاقتك اسمها مختلف
        $invoice->forceFill(['total' => $sum])->saveQuietly();
    }
}
