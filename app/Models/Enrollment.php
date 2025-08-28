<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Enrollment extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id', 'student_id', 'classroom_id',
        'start_date', 'end_date', 'status',
    ];

    public function student()  { return $this->belongsTo(Student::class); }
    public function classroom(){ return $this->belongsTo(Classroom::class); }
}
