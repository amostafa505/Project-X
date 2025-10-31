<?php

namespace App\Filament\Tenant\Resources\Hospital\LabTests\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class LabTestsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
                    ->schema([
                        TextInput::make('name.en')
                            ->label(__('Name (EN)'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('name.ar')
                            ->label(__('Name (AR)'))
                            ->maxLength(255),

                        Textarea::make('description.en')
                            ->label(__('Description (EN)'))
                            ->rows(2),

                        Textarea::make('description.ar')
                            ->label(__('Description (AR)'))
                            ->rows(2),
                    ])
                    ->columns(2),

                Section::make(__('Classification & Pricing'))
                    ->schema([
                        TextInput::make('category.en')
                            ->label(__('Category (EN)')),

                        TextInput::make('category.ar')
                            ->label(__('Category (AR)')),

                        TextInput::make('code')
                            ->label(__('Code'))
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),

                        TextInput::make('unit')
                            ->label(__('Unit'))
                            ->placeholder('mg/dL, IU/L, etc.'),

                        TextInput::make('price')
                            ->label(__('Price'))
                            ->numeric()
                            ->prefix('EGP')
                            ->minValue(0)
                            ->maxValue(100000),

                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->default(true),
                    ])
                    ->columns(3),

                Section::make(__('Reference Range'))
                    ->schema([
                        Textarea::make('reference_range.en')
                            ->label(__('Reference Range (EN)'))
                            ->rows(2)
                            ->helperText(__('Example: Male: 13-17 g/dL | Female: 12-15 g/dL')),

                        Textarea::make('reference_range.ar')
                            ->label(__('Reference Range (AR)'))
                            ->rows(2),
                    ])
                    ->columns(2),

            ]);
    }
}
