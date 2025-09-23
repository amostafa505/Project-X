<?php

namespace App\Filament\Tenant\Traits;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;

trait BranchScoped
{
    /** أضف حقول tenant_id و branch_id تلقائيًا لأي فورم */
    public static function injectTenantBranchHiddenFields(Schema $schema): Schema
    {
        return $schema->schema(array_merge([
            Hidden::make('tenant_id')
                ->default(fn () => tenant('id'))
                ->dehydrated(true),

            Hidden::make('branch_id')
                ->default(fn () => auth()->user()?->branch_id)
                ->dehydrated(true),
        ], $schema->getComponents()));
    }

    /** فلترة أي جدول على tenant_id + branch_id (لو المستخدم مش معاه viewAll) */
    public static function scopeTenantBranch(Table $table): Table
    {
        return $table->modifyQueryUsing(function (Builder $query) {
            if (tenant()) {
                $query->where($query->getModel()->getTable() . '.tenant_id', tenant('id'));
            }
            $user = auth()->user();
            if ($user && !$user->can('branches.viewAll')) {
                $query->where($query->getModel()->getTable() . '.branch_id', $user->branch_id);
            }
            return $query;
        });
    }
}
