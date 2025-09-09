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
    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class, 'class_room_student')
            ->using(\App\Models\Pivots\ClassRoomStudent::class) // ✅ هنا
            ->withPivot(['tenant_id'])
            ->withTimestamps();
    }
}
