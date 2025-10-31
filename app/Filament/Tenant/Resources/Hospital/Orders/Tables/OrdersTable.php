<?php

namespace App\Filament\Tenant\Resources\Hospital\Order\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class OrderTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->colors([
                        'success' => 'lab',
                        'info' => 'imaging',
                        'warning' => 'pharmacy',
                    ])
                    ->formatStateUsing(fn ($state, $record) => $record->typeLabel)
                    ->sortable(),

                TextColumn::make('patient.full_name')
                    ->label(__('Patient'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('doctor.full_name')
                    ->label(__('Doctor'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('title')
                    ->label(__('Title'))
                    ->formatStateUsing(fn ($state, $record) => $record->getTranslatedTitle())
                    ->limit(40)
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label(__('Status'))
                    ->colors([
                        'gray' => 'requested',
                        'warning' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'canceled',
                    ])
                    ->formatStateUsing(fn ($state, $record) => $record->statusLabel)
                    ->sortable(),

                TextColumn::make('ordered_at')
                    ->label(__('Ordered At'))
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('completed_at')
                    ->label(__('Completed At'))
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'lab' => __('Lab Orders'),
                        'imaging' => __('Imaging Orders'),
                        'pharmacy' => __('Pharmacy Orders'),
                    ]),
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'requested' => __('Requested'),
                        'in_progress' => __('In Progress'),
                        'completed' => __('Completed'),
                        'canceled' => __('Canceled'),
                    ]),
                Filter::make('today')
                    ->label(__('Today’s Orders'))
                    ->query(fn ($query) => $query->whereDate('ordered_at', today())),
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
