<?php
namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait TenantScoped
{
    protected static function bootTenantScoped(): void
    {
        static::creating(function (Model $model) {
            if (empty($model->tenant_id) && tenant()) {
                $model->tenant_id = tenant('id');
            }
        });

        static::addGlobalScope('tenant', function (Builder $q) {
            if (tenant()) {
                $q->where($q->getModel()->getTable().'.tenant_id', tenant('id'));
            }
        });
    }
}
