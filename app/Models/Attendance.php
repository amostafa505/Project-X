<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id','student_id','classroom_id','date','status','notes'];

    public function student()   { return $this->belongsTo(Student::class); }
    public function classroom() { return $this->belongsTo(Classroom::class); }
}
