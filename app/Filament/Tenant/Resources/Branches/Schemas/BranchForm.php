<?php

namespace App\Filament\Tenant\Resources\Branches\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tenant_id')
                    ->required(),
                TextInput::make('school_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code'),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('address'),
                TextInput::make('timezone'),
            ]);
    }
}
