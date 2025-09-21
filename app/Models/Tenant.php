<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant
{
    use HasDomains;
    protected $fillable = [
        'id',
        'code',
        'name',
        'type',
        'organization_id',
        'owner_user_id',
        'plan',
        'currency',
        'locale',
        'timezone',
        'status',
        'trial_ends_at',
        'billing_starts_at',
        'data',
        'meta',
    ];

    protected $casts = [
        'data'              => 'array',
        'meta'              => 'array',
        'trial_ends_at'     => 'datetime',
        'billing_starts_at' => 'datetime',
    ];

    /**
     * Get the attributes that should be stored in dedicated columns instead of the 'data' JSON column.
     *
     * @return array
     */
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'code',
            'name',
            'type',
            'organization_id',
            'owner_user_id',
            'plan',
            'currency',
            'locale',
            'timezone',
            'status',
            'trial_ends_at',
            'billing_starts_at',
            'data',
            'meta',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function hasModule(string $module): bool
    {
        return in_array($module, $this->data['modules'] ?? []);
    }

    public function scopeType($q, string $type)
    {
        return $q->where('type', $type);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }
}
