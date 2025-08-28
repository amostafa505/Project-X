<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::creating(function (Model $model) {
            $col = $model->getTenantColumn();

            // Only set if not already set explicitly
            if (empty($model->{$col}) && tenant()) {
                $model->{$col} = tenant()->id;
            }
        });

        static::addGlobalScope('tenant', function (Builder $builder) {
            // Only constrain when tenancy is initialized
            if (tenant()) {
                $model = $builder->getModel();
                $col   = $model->getTenantColumn();

                $builder->where($model->getTable().'.'.$col, tenant()->id);
            }
        });
    }

    /** Column name override via protected $tenantColumn on the model */
    public function getTenantColumn(): string
    {
        return property_exists($this, 'tenantColumn') ? $this->tenantColumn : 'tenant_id';
    }

    /** Query helper: force a specific tenant, ignoring the global scope */
    public function scopeForTenant(Builder $query, $tenantId): Builder
    {
        return $query->withoutGlobalScope('tenant')
            ->where($this->getTable().'.'.$this->getTenantColumn(), $tenantId);
    }

    /** Quick access to current tenant key (null when not initialized) */
    public static function currentTenantKey(): ?string
    {
        return tenant()?->id;
    }

    /** Temporarily remove the scope (useful in admin/maintenance scripts) */
    public function scopeWithoutTenantScope(Builder $query): Builder
    {
        return $query->withoutGlobalScope('tenant');
    }
}
