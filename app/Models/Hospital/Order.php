<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'orders';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'organization_id',
        'encounter_id',
        'patient_id',
        'doctor_id',
        'department_id',
        'type',
        'title',
        'description',
        'status',
        'ordered_at',
        'completed_at',
        'results',
        'notes',
    ];

    public $translatable = ['title', 'description', 'results', 'notes'];

    protected $casts = [
        'ordered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function encounter()
    {
        return $this->belongsTo(Encounter::class);
    }

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

    /*
    |--------------------------------------------------------------------------
    | Helpers & Accessors
    |--------------------------------------------------------------------------
    */

    public function getTranslatedTitle(): ?string
    {
        return $this->getTranslation('title', app()->getLocale()) ?? $this->getTranslation('title', 'en');
    }

    public function getTranslatedDescription(): ?string
    {
        return $this->getTranslation('description', app()->getLocale()) ?? $this->getTranslation('description', 'en');
    }

    public function getTranslatedResults(): ?string
    {
        return $this->getTranslation('results', app()->getLocale()) ?? $this->getTranslation('results', 'en');
    }

    public function getTranslatedNotes(): ?string
    {
        return $this->getTranslation('notes', app()->getLocale()) ?? $this->getTranslation('notes', 'en');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'lab'      => __('Lab Order'),
            'imaging'  => __('Imaging Order'),
            'pharmacy' => __('Pharmacy Order'),
            default    => __('Other'),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'requested'   => __('Requested'),
            'in_progress' => __('In Progress'),
            'completed'   => __('Completed'),
            'canceled'    => __('Canceled'),
            default       => __('Unknown'),
        };
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
