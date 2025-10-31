<?php

namespace App\Filament\Tenant\Resources\Hospital\Encounters\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use App\Models\Hospital\Encounter;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class EncountersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('patient.full_name')->label(__('Patient'))->sortable()->searchable(),
                TextColumn::make('doctor.full_name')->label(__('Doctor'))->sortable()->searchable(),
                TextColumn::make('department.name')
                    ->label(__('Department'))
                    ->formatStateUsing(
                        fn ($state, Encounter $record) =>
                        optional($record->department)?->getTranslation('name', app()->getLocale()) ??
                            optional($record->department)?->getTranslation('name', 'en')
                    )
                    ->sortable(),
                BadgeColumn::make('visit_type')->label(__('Visit type'))
                    ->colors([
                        'success' => 'OPD',
                        'warning' => 'ER',
                        'danger'  => 'IPD',
                    ]),
                TextColumn::make('chief_complaint')
                    ->label(__('Chief complaint'))
                    ->formatStateUsing(
                        fn ($state, Encounter $record) =>
                        $record->getTranslation('chief_complaint', app()->getLocale()) ??
                            $record->getTranslation('chief_complaint', 'en')
                    )
                    ->limit(30),
                TextColumn::make('started_at')->dateTime()->label(__('Started at'))->sortable(),
                TextColumn::make('ended_at')->dateTime()->label(__('Ended at'))->sortable(),
            ])
            ->filters([
                SelectFilter::make('visit_type')->options([
                    'OPD' => 'Outpatient',
                    'ER'  => 'Emergency',
                    'IPD' => 'Inpatient',
                ]),
                Filter::make('today')
                    ->label(__('Today'))
                    ->query(fn ($q) => $q->whereDate('started_at', now()->toDateString())),

            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
