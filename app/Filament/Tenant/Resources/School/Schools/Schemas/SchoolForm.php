<?php

namespace App\Filament\Tenant\Resources\School\Schools\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SchoolForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tenant_id')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('address'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
            ]);
    }
}
