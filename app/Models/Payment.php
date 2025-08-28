<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id','invoice_id','method','amount','currency','paid_at','reference'];

    public function invoice() { return $this->belongsTo(Invoice::class); }
}
