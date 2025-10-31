<?php

namespace App\Filament\Tenant\Resources\Hospital\Patients\Tables;

use Filament\Tables\Table;
use App\Models\Hospital\Patient;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mrn')->label('MRN')->searchable(),
                TextColumn::make('full_name')->label(__('Patients'))
                    ->getStateUsing(fn (Patient $r) => trim(($r->first_name ?? '') . ' ' . ($r->last_name ?? '')))
                    ->searchable(['first_name', 'last_name', 'mrn', 'phone', 'email']),
                TextColumn::make('gender')->badge()->toggleable(),
                TextColumn::make('dob')->date()->toggleable(),
                TextColumn::make('phone')->toggleable(),
                TextColumn::make('created_at')->dateTime()->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('has_phone')->label(__('Has phone'))
                    ->query(fn ($q) => $q->whereNotNull('phone')->where('phone', '<>', '')),
                Filter::make('recent')->label(__('Created last 7 days'))
                    ->query(fn ($q) => $q->where('created_at', '>=', now()->subDays(7))),
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
