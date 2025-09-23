<?php

namespace App\Filament\Central\Resources\Tenants\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Identity')
                ->columns(3)
                ->schema([
                    TextInput::make('code')
                        ->label('Code')
                        ->helperText('مختصر فريد مثل: ANDA-SCH-001')
                        ->required()
                        ->maxLength(50)
                        ->regex('/^[A-Z0-9\-\._]+$/')
                        ->dehydrateStateUsing(fn ($state) => strtoupper(trim($state)))
                        ->unique('tenants', 'code', ignoreRecord: true),

                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->maxLength(150),

                    Select::make('type')
                        ->label('Type')
                        ->options([
                            'school'   => 'School',
                            'clinic'   => 'Clinic',
                            'pharmacy' => 'Pharmacy',
                            // زوّد أنواع تانية عند الحاجة
                        ])
                        ->default('school')
                        ->required(),
                ]),

            Section::make('Ownership & Grouping')
                ->columns(2)
                ->schema([
                    Select::make('organization_id')
                        ->label('Organization')
                        ->relationship('organization', 'name')
                        ->searchable()->preload()->nullable(),

                    Select::make('owner_user_id')
                        ->label('Owner User')
                        ->relationship('owner', 'name')
                        ->searchable()->preload()->nullable(),
                ]),

            Section::make('Commercial & Locale')
                ->columns(4)
                ->schema([
                    Select::make('plan')
                        ->label('Plan')
                        ->options([
                            'free'       => 'Free',
                            'pro'        => 'Pro',
                            'enterprise' => 'Enterprise',
                        ])
                        ->default('free')->required(),

                    TextInput::make('currency')
                        ->label('Currency (ISO 4217)')
                        ->default('EGP')
                        ->maxLength(3)
                        ->dehydrateStateUsing(fn ($s) => strtoupper(trim($s)))
                        ->required(),

                    Select::make('locale')
                        ->label('Locale')
                        ->options([
                            'ar' => 'Arabic (ar)',
                            'en' => 'English (en)',
                            'fr' => 'French (fr)',
                        ])->default('ar')->required(),

                    TextInput::make('timezone')
                        ->label('Timezone')
                        ->default('Africa/Cairo')
                        ->required(),
                ]),

            Section::make('Lifecycle')
                ->columns(3)
                ->schema([
                    Select::make('status')
                        ->label('Status')
                        ->options([
                            'active'     => 'Active',
                            'trial'      => 'Trial',
                            'suspended'  => 'Suspended',
                            'cancelled'  => 'Cancelled',
                        ])->default('active')->required(),

                    DateTimePicker::make('trial_ends_at')->label('Trial ends at')->seconds(false)->native(false),
                    DateTimePicker::make('billing_starts_at')->label('Billing starts at')->seconds(false)->native(false),
                ]),

            Section::make('Config')
                ->columns(2)
                ->schema([
                    KeyValue::make('data')
                        ->label('Data (JSON)')
                        ->keyLabel('Key')->valueLabel('Value')
                        ->addable()->editableKeys()->reorderable()
                        ->nullable(),

                    KeyValue::make('meta')
                        ->label('Meta (JSON)')
                        ->keyLabel('Key')->valueLabel('Value')
                        ->addable()->editableKeys()->reorderable()
                        ->nullable(),
                ]),
        ]);
    }
}
