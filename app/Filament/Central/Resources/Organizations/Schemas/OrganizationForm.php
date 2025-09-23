<?php

namespace App\Filament\Central\Resources\Organizations\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Organization Info')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->maxLength(150),

                    Select::make('owner_user_id')
                        ->label('Owner')
                        ->relationship('owner', 'name') // Organization::owner() -> belongsTo(User::class)
                        ->searchable()
                        ->preload()
                        ->nullable(),
                ]),

            Section::make('Settings')
                ->schema([
                    KeyValue::make('settings')
                        ->label('Settings (JSON)')
                        ->keyLabel('Key')
                        ->valueLabel('Value')
                        ->addable()
                        ->editableKeys()
                        ->reorderable()
                        ->nullable(),
                ]),
        ]);
    }
}
