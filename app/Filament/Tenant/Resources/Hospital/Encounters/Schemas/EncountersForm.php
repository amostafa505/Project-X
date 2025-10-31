<?php

namespace App\Filament\Tenant\Resources\Hospital\Encounters\Schemas;

use Filament\Schemas\Schema;
use App\Models\Hospital\Doctor;
use App\Models\Hospital\Patient;
use App\Models\Hospital\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class EncountersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->label(__('Patient'))
                    ->relationship('patient', 'first_name', modifyQueryUsing: fn ($q) => $q->orderBy('first_name'))
                    ->searchable()
                    ->preload()
                    ->getOptionLabelUsing(fn ($v) => optional(Patient::find($v))?->full_name ?? ''),
                Select::make('doctor_id')
                    ->label(__('Doctor'))
                    ->relationship('doctor', 'first_name', modifyQueryUsing: fn ($q) => $q->orderBy('first_name'))
                    ->searchable()
                    ->preload()
                    ->getOptionLabelUsing(fn ($v) => optional(Doctor::find($v))?->full_name ?? ''),
                Select::make('department_id')
                    ->label(__('Department'))
                    ->relationship('department', 'name')
                    ->getOptionLabelUsing(fn ($v) => optional(Department::find($v))?->getTranslation('name', app()->getLocale()) ?? ''),
                Select::make('visit_type')
                    ->label(__('Visit type'))
                    ->options([
                        'OPD' => 'Outpatient',
                        'ER' => 'Emergency',
                        'IPD' => 'Inpatient'
                    ])->default('OPD')->native(false),
            ])->columns(2);

        Section::make(__('Clinical info'))
            ->schema([
                TextInput::make('chief_complaint.en')->label(__('Chief complaint') . ' (EN)'),
                TextInput::make('chief_complaint.ar')->label(__('Chief complaint') . ' (AR)'),

                Textarea::make('notes.en')->label(__('Notes') . ' (EN)')->rows(2),
                Textarea::make('notes.ar')->label(__('Notes') . ' (AR)')->rows(2),

                KeyValue::make('vitals')
                    ->label(__('Vitals'))
                    ->keyLabel(__('Metric'))
                    ->valueLabel(__('Value'))
                    ->reorderable()
                    ->addButtonLabel(__('Add vital')),
            ])->columns(2);

        Section::make(__('Visit timing'))
            ->schema([
                DateTimePicker::make('started_at')->label(__('Started at')),
                DateTimePicker::make('ended_at')->label(__('Ended at')),
            ])->columns(2);
    }
}
