<?php

namespace App\Models;

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
    public function classrooms()
    {
        return $this->hasMany(\App\Models\Classroom::class, 'branch_id');
    }
    public function subjects()
    {
        return $this->hasMany(\App\Models\Subject::class);
    }
}
