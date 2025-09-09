<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id','invoice_id','fee_item_id','item','qty','unit_price','total'];

    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function feeItem() { return $this->belongsTo(FeeItem::class); }

    protected static function booted(): void
{
    static::saving(function ($m) {
        if (!$m->item && $m->fee_item_id) {
            $m->item = optional($m->feeItem)->name;
        }
        $m->line_total = round((float)($m->qty ?? 0) * (float)($m->unit_price ?? 0), 2);
        if (!$m->tenant_id && function_exists('tenant') && tenant()) {
            $m->tenant_id = tenant('id');
        }
    });
}
}
