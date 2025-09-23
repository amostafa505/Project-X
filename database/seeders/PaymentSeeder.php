<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Branch;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $invoice = Invoice::first();
        $branch  = Branch::first();

        if (!$invoice || !$branch) return;

        Payment::create([
            'tenant_id'  => tenant('id'),
            'invoice_id' => $invoice->id,
            'branch_id'  => $branch->id,
            'method'     => 'cash',
            'amount'     => $invoice->amount,
            'currency'   => 'EGP',
            'paid_at'    => now(),
            'reference'  => 'PAY-001',
        ]);
    }
}
