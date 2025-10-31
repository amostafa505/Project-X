<?php

namespace App\Filament\Tenant\Resources\Hospital\Patients\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;

class PatientsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    TextInput::make('mrn')->label('MRN')->required()->unique(ignoreRecord: true),
                    TextInput::make('first_name')->label(__('First name'))->required(),
                    TextInput::make('last_name')->label(__('Last name')),
                    Select::make('gender')->options([
                        'male' => __('Male'), 'female' => __('Female'), 'other' => __('Other')
                    ])->native(false),
                    DatePicker::make('dob')->label(__('Date of birth')),
                    TextInput::make('phone'),
                    TextInput::make('email')->email(),
                    TextInput::make('address.en')->label(__('Address') . ' (EN)'),
                    TextInput::make('address.ar')->label(__('Address') . ' (AR)'),
                    TextInput::make('blood_group')->label(__('Blood group')),
                    Textarea::make('allergies')->rows(2)->columnSpanFull(),
                    Textarea::make('chronic_conditions')->rows(2)->columnSpanFull(),
                ])->columns(2),
            ]);
    }
}
