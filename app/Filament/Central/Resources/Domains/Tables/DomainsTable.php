<?php

namespace App\Filament\Central\Resources\Domains\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;


class DomainsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('domain')->label('Domain')->searchable()->copyable()->sortable(),
                TextColumn::make('tenant.code')->label('Tenant Code')->toggleable(true)->searchable(),
                TextColumn::make('tenant.name')->label('Tenant Name')->toggleable(true)->searchable(),
                IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean(),
                TextColumn::make('created_at')->label('Created')->since()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('tenant_id')
                    ->relationship('tenant', 'name')
                    ->label('Tenant'),
                SelectFilter::make('is_primary')
                    ->label('Primary')
                    ->options(['1' => 'Yes', '0' => 'No']),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->with('tenant'))
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    Action::make('makePrimary')
                        ->label('Make Primary')
                        ->requiresConfirmation()
                        ->visible(fn ($record) => !$record->is_primary)
                        ->action(function ($record) {
                            // set current as primary and unset others (model boot ensures consistency too)
                            $record->update(['is_primary' => true]);
                        }),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
