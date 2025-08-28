<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Teacher extends Model
{
    use BelongsToTenant ,HasFactory;

    protected $fillable = ['tenant_id','branch_id','name','email','phone','status'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
