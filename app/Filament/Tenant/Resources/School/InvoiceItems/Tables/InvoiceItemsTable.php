<?php

namespace App\Filament\Tenant\Resources\School\InvoiceItems\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class InvoiceItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.number')->label('Invoice #')->searchable(),
                TextColumn::make('item')->label('Item')->searchable(),
                TextColumn::make('qty'),
                TextColumn::make('unit_price')->money('egp', true),
                TextColumn::make('line_total')->label('Total')->money('egp', true),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
