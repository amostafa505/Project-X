<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Student extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id', 'branch_id', 'school_id', 'first_name', 'last_name', 'status', 'guardian_id', 'code', 'dob', 'gender'
    ];

    protected $casts = [
        'dob' => 'date',            // مهم علشان DatePicker
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function classrooms()
    {
        return $this->belongsToMany(\App\Models\Classroom::class, 'enrollments', 'student_id', 'classroom_id')
            ->withPivot(['tenant_id', 'start_date', 'end_date', 'status'])
            ->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
