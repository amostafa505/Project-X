<?php

namespace App\Filament\Tenant\Resources\Hospital\LabTests\Tables;

use Filament\Tables\Table;
use App\Models\Hospital\LabTest;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;

class LabTestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->getStateUsing(fn (LabTest $record) => $record->getTranslation('name', app()->getLocale()) ?? $record->getTranslation('name', 'en'))
                    ->searchable(),

                TextColumn::make('category')
                    ->label(__('Category'))
                    ->getStateUsing(fn (LabTest $record) => $record->getTranslation('category', app()->getLocale()) ?? $record->getTranslation('category', 'en'))
                    ->sortable()
                    ->badge(),

                TextColumn::make('unit')
                    ->label(__('Unit'))
                    ->sortable(),

                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('EGP', true)
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category.en')
                    ->label(__('Category'))
                    ->options(
                        fn () => LabTest::query()
                            ->select('category->en')
                            ->distinct()
                            ->pluck('category->en', 'category->en')
                            ->filter()
                    ),
                TernaryFilter::make('is_active')
                    ->label(__('Active')),
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
