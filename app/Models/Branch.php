<?php

namespace App\Models;

// use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;


class Branch extends Model
{
    use BelongsToTenant , HasFactory;

    protected $fillable = ['tenant_id','school_id','name','code','phone','address','timezone'];

    public function school()
    {
        return $this->belongsTo(\App\Models\School::class , 'school_id');
    }
    public function subjects()
    {
        return $this->hasMany(\App\Models\Subject::class);
    }
}
