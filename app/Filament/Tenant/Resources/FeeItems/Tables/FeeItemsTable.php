<?php

namespace App\Filament\Tenant\Resources\FeeItems\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class FeeItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('code')->badge(),
                TextColumn::make('default_amount')->money('egp', true),
            ])
            ->recordActions([ EditAction::make(), DeleteAction::make() ])
            ->toolbarActions([
                BulkActionGroup::make([ DeleteBulkAction::make() ]),
            ]);
    }
}
