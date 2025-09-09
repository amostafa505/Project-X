<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{

    public function saved(Invoice $invoice): void
    {
        // تأكيد توحيد القيمة بعد أي تعديل على الفاتورة
        $sum = $invoice->items()->sum('total'); // غيّر items لو علاقتك اسمها مختلف
        if ((float) $invoice->total !== (float) $sum) {
            $invoice->forceFill(['total' => $sum])->saveQuietly();
        }
    }

    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
