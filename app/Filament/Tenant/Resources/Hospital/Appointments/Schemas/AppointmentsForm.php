<?php

namespace App\Filament\Tenant\Resources\Hospital\Appointments\Schemas;

use Filament\Schemas\Schema;
use App\Models\Hospital\Doctor;
use App\Models\Hospital\Patient;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\Builder;


class AppointmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Select::make('patient_id')
                        ->label(__('Patient'))
                        ->searchable()
                        ->preload()
                        ->relationship(
                            name: 'patient',
                            titleAttribute: 'first_name',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name'),
                        )
                        ->getOptionLabelFromRecordUsing(fn (Patient $record) => $record->full_name),
                    Select::make('doctor_id')
                        ->label(__('Doctor'))
                        ->searchable()
                        ->preload()
                        ->relationship(
                            name: 'doctor',
                            titleAttribute: 'first_name',
                            modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name'),
                        )
                        ->getOptionLabelFromRecordUsing(fn (Doctor $record) => $record->full_name),
                    DateTimePicker::make('scheduled_at')->label(__('Scheduled at'))->seconds(false)->required(),
                    Select::make('status')->label(__('Status'))->options([
                        'booked' => __('Booked'),
                        'checked-in' => __('Checked-in'),
                        'no-show' => __('No-show'),
                        'completed' => __('Completed'),
                        'canceled' => __('Canceled'),
                    ])->default('booked')->native(false),
                    Textarea::make('notes.en')->label(__('Notes') . ' (EN)')->rows(2),
                    Textarea::make('notes.ar')->label(__('Notes') . ' (AR)')->rows(2),
                ])->columns(2),
            ]);
    }
}
