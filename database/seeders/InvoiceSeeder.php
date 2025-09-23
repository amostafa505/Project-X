<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Branch;
use App\Models\Student;
use App\Models\FeeItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $tenant   = tenant();
        $branch   = Branch::first();
        $student  = Student::first();
        $feeItem  = FeeItem::first();

        if (!$tenant || !$branch || !$student || !$feeItem) return;

        $invoice = Invoice::create([
            'tenant_id'  => $tenant->id,
            'branch_id'  => $branch->id,
            'student_id' => $student->id,
            'number'     => 'INV-' . Str::upper(Str::random(6)),
            'amount'     => $feeItem->default_amount,
            'currency'   => $tenant->currency ?? 'EGP',
            'status'     => 'unpaid',
            'issue_date' => now(),
            'due_date'   => now()->addDays(30),
        ]);

        InvoiceItem::create([
            'tenant_id'   => $tenant->id,
            'invoice_id'  => $invoice->id,
            'fee_item_id' => $feeItem->id,
            'qty'         => 1,
            'item'        => $feeItem->name,
            'unit_price'  => $feeItem->default_amount,
            'line_total'  => $feeItem->default_amount,
        ]);
    }
}
