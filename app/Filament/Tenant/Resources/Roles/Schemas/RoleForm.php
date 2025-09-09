<?php

namespace App\Filament\Tenant\Resources\Roles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),
                TextInput::make('name')->required()->maxLength(150),
                TextInput::make('guard_name')->default('web')->disabled(),
                Select::make('permissions')
                    ->relationship('permissions', 'name')
                    ->multiple()->preload()->searchable(),
            ]);
    }
}
