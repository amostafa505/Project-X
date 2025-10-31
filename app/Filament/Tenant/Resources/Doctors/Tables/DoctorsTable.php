<?php

namespace App\Filament\Tenant\Resources\Doctors\Tables;

use Filament\Tables\Table;
use App\Models\Hospital\Doctor;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label(__('Doctors'))
                    ->getStateUsing(fn (Doctor $r) => trim(($r->first_name ?? '') . ' ' . ($r->last_name ?? '')))
                    ->searchable(['first_name', 'last_name', 'email', 'phone']),
                TextColumn::make('specialty')->label(__('Specialty'))->sortable()->searchable(),
                TextColumn::make('phone')->toggleable(),
                IconColumn::make('is_active')->boolean()->label(__('Active'))->sortable(),
                TextColumn::make('created_at')->dateTime()->since()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label(__('Active')),
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
