<?php

namespace App\Filament\Tenant\Resources\School\Invoices\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;

class InvoiceItemsRelationManager extends RelationManager
{
    // اسم العلاقة في App\Models\Invoice
    protected static string $relationship = 'items'; // غيّرها لو اسمها invoiceItems

    public function form(Schema $schema): Schema   // ✅ غير ستاتيك وبـ Schema
    {
        return $schema->components([
            Forms\Components\Select::make('fee_item_id')
                ->label('Fee Item')
                ->relationship('feeItem', 'name')
                ->searchable()
                ->preload()
                ->required(),

            Forms\Components\TextInput::make('qty')
                ->numeric()
                ->minValue(1)
                ->default(1)
                ->required()
                ->reactive()
                ->afterStateUpdated(
                    fn ($state, $set, $get) =>
                    $set('total', (float) $state * (float) $get('unit_price'))
                ),

            Forms\Components\TextInput::make('unit_price')
                ->numeric()
                ->prefix('EGP')
                ->minValue(0)
                ->required()
                ->reactive()
                ->afterStateUpdated(
                    fn ($state, $set, $get) =>
                    $set('total', (float) $get('qty') * (float) $state)
                ),

            // النهائي بيتحسب في الـ Observer — نعرضه فقط
            Forms\Components\TextInput::make('amount')
                ->numeric()
                ->prefix('EGP')
                ->disabled()
                ->dehydrated(false),
        ]);
    }

    public function table(Table $table): Table     // ✅ غير ستاتيك
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('feeItem.name')->label('Fee')->searchable(),
                Tables\Columns\TextColumn::make('qty'),
                Tables\Columns\TextColumn::make('unit_price')->money('egp', true),
                Tables\Columns\TextColumn::make('amount')->money('egp', true),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn () => auth()->user()->can('invoice_items.create')),
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn () => auth()->user()->can('invoice_items.update')),
                DeleteAction::make()
                    ->visible(fn () => auth()->user()->can('invoice_items.delete')),
            ]);
    }
}
