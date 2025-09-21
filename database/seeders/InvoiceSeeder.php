<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Tenant;
use App\Models\FeeItem;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\InvoiceItem;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $student = Student::first();
        $feeItem = FeeItem::first();
        $branch   = Branch::first();
        $tenants = Tenant::first();

        $invoice = Invoice::create([
            'tenant_id'  => $tenants->id,
            'student_id' => $student->id,
            'branch_id'  => $branch->id,
            'number'     => 'INV-001',
            'status'     => 'unpaid',
            'amount'      => $feeItem->default_amount,
            'currency'   => 'EGP',
            // 'issued_at'  => now(),
            'due_date'     => now()->addDays(30),
        ]);

        InvoiceItem::create([
            'tenant_id'   => $tenants->id,
            'invoice_id'  => $invoice->id,
            'fee_item_id' => $feeItem->id,
            'qty'         => 1,
            'item'        => $feeItem->name,
            'unit_price'  => $feeItem->default_amount,
            'line_total'  => $feeItem->default_amount,
        ]);
    }
}
