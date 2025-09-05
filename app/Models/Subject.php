<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;


class Subject extends Model
{
    use BelongsToTenant , HasFactory;

    protected $fillable = ['tenant_id','branch_id','name','code'];

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
}
