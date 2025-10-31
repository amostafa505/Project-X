<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Encounter extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'encounters';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'organization_id',
        'patient_id',
        'doctor_id',
        'department_id',
        'appointment_id',
        'visit_type',
        'chief_complaint',
        'notes',
        'vitals',
        'started_at',
        'ended_at',
    ];

    public $translatable = ['chief_complaint', 'notes', 'vitals'];

    protected $casts = [
        'vitals' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers & Accessors
    |--------------------------------------------------------------------------
    */

    public function getVisitTypeLabelAttribute(): string
    {
        return match ($this->visit_type) {
            'OPD' => __('Outpatient'),
            'ER'  => __('Emergency'),
            'IPD' => __('Inpatient'),
            default => __('Unknown'),
        };
    }

    public function getDisplayChiefComplaintAttribute(): ?string
    {
        return $this->getTranslation('chief_complaint', app()->getLocale())
            ?? $this->getTranslation('chief_complaint', 'en');
    }

    public function getDisplayNotesAttribute(): ?string
    {
        return $this->getTranslation('notes', app()->getLocale())
            ?? $this->getTranslation('notes', 'en');
    }
}
