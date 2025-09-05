<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;



class Classroom extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id', 'branch_id', 'teacher_id',
        'name', 'code', 'capacity', 'grade_level',
        'status', 'notes',
    ];

    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class, 'branch_id');
    }
    public function teacher()
    {
         return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id');
    }
}
