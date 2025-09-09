<?php

namespace App\Filament\Central\Resources\Tenants\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(150),
            KeyValue::make('data')->label('Meta')->addButtonLabel('Add Meta')->keyLabel('Key')->valueLabel('Value'),
        ]);
    }
}
