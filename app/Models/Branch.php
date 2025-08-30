<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use BelongsToTenant , HasFactory;

    protected $fillable = ['tenant_id','school_id','name','code','phone','address','timezone'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function subjects()
    {
        return $this->hasMany(\App\Models\Subject::class);
    }
}
