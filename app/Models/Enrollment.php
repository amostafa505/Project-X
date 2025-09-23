<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use BelongsToTenant;
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'student_id',
        'classroom_id',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            // لو فيه Tenancy loaded، خزّنه
            if (blank($model->tenant_id) && function_exists('tenant') && tenant()) {
                $model->tenant_id = tenant('id');
            }

            // fallback لو مافيش tenant() (مثلاً لو الداشبورْد اتحمّل مركزي بالغلط)
            if (blank($model->tenant_id) && auth()->check()) {
                // لو عندك Pivot TenantUser أو current_tenant_id على المستخدم، عدّله هنا
                $model->tenant_id = auth()->user()->tenant_id ?? $model->tenant_id;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getSchoolYearAttribute(): string
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('Y') . ' - ' . $this->end_date->format('Y');
        }

        return '';
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
    public function scopeForTenant($q, $tenantId = null)
    {
        return $q->where('tenant_id', $tenantId ?? tenant('id'));
    }
}
