<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Domain as BaseDomain;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Domain extends BaseDomain
{
    protected $table = 'domains';

    protected $fillable = ['tenant_id', 'domain', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            // normalize domain
            $model->domain = strtolower(trim($model->domain));
        });

        // ensure one primary per tenant
        $syncOthers = function (self $model): void {
            if ($model->is_primary) {
                static::where('tenant_id', $model->tenant_id)
                    ->where('id', '<>', $model->id)
                    ->update(['is_primary' => false]);
            }
        };

        static::created($syncOthers);
        static::updated(function (self $model) use ($syncOthers) {
            if ($model->wasChanged('is_primary')) {
                $syncOthers($model);
            }
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Tenant::class, 'tenant_id', 'id');
    }
}
