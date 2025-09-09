<?php

namespace App\Filament\Tenant\Resources\Students\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RelationRepeater;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')
                    ->default(fn () => tenant('id'))
                    ->dehydrated(true),
                Select::make('school_id')
                    ->label('School')
                    ->relationship('school', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live(),
                Select::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name') // اسم العلاقة لازم "branch"
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('guardian_id')
                    ->label('Guardian')
                    ->relationship('guardian', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                // RelationRepeater::make('guardians')
                // ->label('Guardians')
                // ->relationship('guardians') // ← اسم العلاقة في Student model
                // ->schema([
                //     // لو guardians موجودين مسبقًا وتربطهم فقط:
                //     Select::make('id')
                //         ->label('Guardian')
                //         ->relationship('guardians', 'name') // يملأ القائمة من جدول guardians
                //         ->searchable()->preload()
                //         ->required()
                //         ->columnSpanFull(),
                //     // بديل: لو عايز إنشاء Guardian جديد inline (لو العلاقة hasMany بدل many-to-many)
                //     // TextInput::make('name')->required(),
                //     // TextInput::make('phone')->tel(),
                //     // TextInput::make('relation')->maxLength(50),
                // ])
                // ->addActionLabel('Add Guardian')
                // ->grid(1)
                // ->orderable(false),


                TextInput::make('first_name')
                    ->label('First name')
                    ->required()
                    ->maxLength(150),

                TextInput::make('last_name')
                    ->label('Last name')
                    ->required()
                    ->maxLength(150),
                TextInput::make('code')
                    ->label('Code')
                    ->maxLength(50),
                DatePicker::make('dob')
                    ->label('Date of birth')
                    ->native(false)
                    ->closeOnDateSelection(),
                Radio::make('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->inline()
                    ->columnSpanFull()
                    ->nullable(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active'    => 'Active',
                        'inactive'  => 'Inactive',
                        'suspended' => 'Suspended',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
