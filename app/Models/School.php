<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;



class School extends Model
{
    use BelongsToTenant ,HasFactory;

    protected static function booted()
    {
        static::creating(function ($m) { $m->tenant_id ??= tenant('id'); });

        static::addGlobalScope('tenant', function ($q) {
            if (tenant()) $q->where('tenant_id', tenant('id'));
        });
    }

    protected $fillable = ['tenant_id','name','code','phone','address','status'];

    public function branches()
    {
        return $this->hasMany(\App\Models\Branch::class);
    }
}
