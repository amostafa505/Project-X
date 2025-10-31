<?php

namespace App\Filament\Tenant\Resources\Appointments\Tables;

use Filament\Tables\Table;
use App\Models\Hospital\Doctor;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')->label(__('Scheduled at'))->dateTime()->sortable(),
                TextColumn::make('patient.full_name')->label(__('Patient'))->searchable(['patient.first_name', 'patient.last_name', 'patient.mrn']),
                TextColumn::make('doctor.full_name')->label(__('Doctor'))->searchable(['doctor.first_name', 'doctor.last_name']),
                BadgeColumn::make('status')->colors([
                    'primary' => 'booked',
                    'success' => 'completed',
                    'warning' => 'checked-in',
                    'danger'  => 'canceled',
                ])->label(__('Status')),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'booked'     => __('Booked'),
                    'checked-in' => __('Checked-in'),
                    'no-show'    => __('No-show'),
                    'completed'  => __('Completed'),
                    'canceled'   => __('Canceled'),
                ]),
                Filter::make('today')->label(__('Today'))
                    ->query(fn ($q) => $q->whereDate('scheduled_at', now()->toDateString())),
                Filter::make('doctor')->form([
                    Select::make('doctor_id')->label(__('Doctor'))
                        ->options(Doctor::query()->orderBy('first_name')->pluck('first_name', 'id'))
                        ->searchable()->preload()
                ])->query(fn ($q, $data) => $data['doctor_id'] ? $q->where('doctor_id', $data['doctor_id']) : $q),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
