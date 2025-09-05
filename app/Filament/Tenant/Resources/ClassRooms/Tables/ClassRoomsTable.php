<?php

namespace App\Filament\Tenant\Resources\ClassRooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClassRoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->sortable(),

                TextColumn::make('grade')
                    ->label('Grade')
                    ->badge(),

                TextColumn::make('capacity')
                    ->label('Capacity')
                    ->badge(),

                TextColumn::make('section')
                ->label('Section')
                ->badge(),

                TextColumn::make('created_at')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('branch') // اسم العلاقة
                ->relationship('branch', 'name')
                ->preload()
                ->searchable(),

                SelectFilter::make('grade')
                    ->options(fn () => collect(range(1, 12))->mapWithKeys(fn ($g) => [$g => "Grade $g"])->all()),
                SelectFilter::make('section')
                    ->options(['A' => 'A', 'B' => 'B', 'C' => 'C']),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
