<?php

namespace App\Filament\Tenant\Resources\School\Teachers\Schemas;

use App\Models\Teacher;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Filament\Forms\Components as F;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class TeacherForm
{
    /**
     * v4 Schemas API:
     * - Accepts & returns Schema.
     * - Use ->components([...]) and put Forms components inside.
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // tenant_id explicit
                F\Hidden::make('tenant_id')
                    ->default(fn () => tenant('id'))
                    ->dehydrated()
                    ->required(),

                Select::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name') // assumes Teacher->branch() belongsTo
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->rule(
                        fn (?Teacher $record) => Rule::unique('teachers', 'email')
                            ->where('tenant_id', tenant('id'))
                            ->ignore($record?->getKey())
                    ),

                TextInput::make('phone')
                    ->tel()
                    ->maxLength(50),

                TextInput::make('employee_code')
                    ->label('Employee Code')
                    ->maxLength(50)
                    ->rule(
                        fn (?Teacher $record) => Rule::unique('teachers', 'employee_code')
                            ->where('tenant_id', tenant('id'))
                            ->ignore($record?->getKey())
                    ),

                TextInput::make('specialization')
                    ->maxLength(255),

                Select::make('status')
                    ->options([
                        'active'    => 'Active',
                        'inactive'  => 'Inactive',
                        'suspended' => 'Suspended',
                    ])
                    ->default('active')
                    ->required()
                    ->native(false),

                DatePicker::make('hiring_date')
                    ->native(false)
                    ->closeOnDateSelection(),
            ]);
    }
}
