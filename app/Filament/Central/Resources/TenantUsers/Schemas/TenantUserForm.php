<?php

namespace App\Filament\Central\Resources\TenantUsers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TenantUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('tenant_id')
                ->relationship('tenant', 'name')->searchable()
                ->preload()
                ->required(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('role')
                ->maxLength(100),
        ]);
    }
}
