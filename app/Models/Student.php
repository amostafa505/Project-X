<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Student extends Model
{
    use BelongsToTenant , HasFactory;

    protected $fillable = [
        'tenant_id','branch_id','first_name','last_name','email','phone','status','guardian_id'
    ];

    public function branch()   { return $this->belongsTo(Branch::class); }
    public function guardian() { return $this->belongsTo(Guardian::class); }
}
