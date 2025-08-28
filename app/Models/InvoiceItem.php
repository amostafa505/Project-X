<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id','invoice_id','fee_item_id','qty','unit_price','total'];

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function feeItem() { return $this->belongsTo(FeeItem::class); }
}
