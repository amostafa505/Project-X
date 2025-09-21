<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Tenant;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $invoice = Invoice::first();
        $branch   = Branch::first();
        $tenants = Tenant::first();

        Payment::create([
            'tenant_id'  => $tenants->id,
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
