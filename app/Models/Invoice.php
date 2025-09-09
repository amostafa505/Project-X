<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Invoice extends Model
{
    use BelongsToTenant ,HasFactory;

    protected $fillable = ['tenant_id','student_id','branch_id','number','status','amount','currency','issued_at','due_date'];
    protected $casts = [
        'issue_date' => 'date',
        'due_date'   => 'date',
        'amount'      => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }
}
