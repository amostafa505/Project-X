<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Subject extends Model
{
    use BelongsToTenant , HasFactory;

    protected $fillable = ['tenant_id','name','code'];

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
}
