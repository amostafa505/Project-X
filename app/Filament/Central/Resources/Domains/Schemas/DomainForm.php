<?php

namespace App\Filament\Central\Resources\Domains\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class DomainForm
{
    public static function configure(Schema $schema): Schema
    {
        $hostRegex = '/^(?!-)[a-z0-9-]{1,63}(?:\.(?!-)[a-z0-9-]{1,63})*$/';

        return $schema->schema([
            Section::make('Domain')
                ->columns(2)
                ->schema([
                    Select::make('tenant_id')
                        ->label('Tenant')
                        ->relationship('tenant', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    TextInput::make('domain')
                        ->label('Domain (host only)')
                        ->placeholder('tenant2.project-x.test')
                        ->required()
                        ->maxLength(255)
                        ->regex($hostRegex)
                        ->unique('domains', 'domain', ignoreRecord: true)
                        ->dehydrated(true),

                    Toggle::make('is_primary')
                        ->label('Primary domain')
                        ->helperText('Only one primary domain per tenant will be kept.'),
                ]),
        ]);
    }
}
