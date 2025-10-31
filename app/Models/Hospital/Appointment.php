<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Appointment extends Model
{
    protected $table = 'appointments';
    use HasTranslations;

    protected $fillable = [
        'tenant_id', 'branch_id', 'organization_id',
        'patient_id', 'doctor_id', 'scheduled_at', 'status', 'notes'
    ];

    public $translatable = ['notes'];


    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
