<?php

namespace App\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClassRoomStudent extends Pivot
{
    protected $table = 'class_room_student';

    protected $fillable = ['tenant_id', 'class_room_id', 'student_id'];

    protected static function booted(): void
    {
        static::creating(function (self $pivot) {
            $pivot->tenant_id ??= tenant('id'); // يملأ tenant_id تلقائيًا
        });
    }
}
