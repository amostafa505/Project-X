<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Invoice extends Model
{
    use BelongsToTenant ,HasFactory;

    protected $fillable = ['tenant_id','student_id','number','status','total','currency','issued_at','due_at'];

    public function student() { return $this->belongsTo(Student::class); }
    public function items()   { return $this->hasMany(InvoiceItem::class); }
    public function payments(){ return $this->hasMany(Payment::class); }
}
