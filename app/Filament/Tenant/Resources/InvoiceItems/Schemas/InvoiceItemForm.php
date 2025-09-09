<?php

namespace App\Filament\Tenant\Resources\InvoiceItems\Schemas;

use App\Models\FeeItem;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class InvoiceItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
        ->components([
            Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),
            Select::make('invoice_id')
                ->relationship('invoice', 'number')
                ->searchable()->preload()->required(),
            Select::make('fee_item_id')
            ->relationship('feeItem', 'name')
            ->searchable()
            ->preload()
            ->required()
            ->live() // مهم
            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                $fee = FeeItem::find($state);
                $set('item', $fee?->name);
                $set('unit_price', (float)($fee?->default_price ?? 0));

                $qty = (int) ($get('qty') ?? 1);
                $set('line_total', (float) $qty * (float) ($fee?->default_price ?? 0));
            }),
            TextInput::make('qty')
            ->numeric()
            ->minValue(1)
            ->default(1)
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set) {
                $set('line_total', (float) ($get('qty') ?? 0) * (float) ($get('unit_price') ?? 0));
            })
            ->required(),
            TextInput::make('unit_price')
            ->numeric()->prefix('EGP')
            ->minValue(0)
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set) {
                $set('line_total', (float) ($get('qty') ?? 0) * (float) ($get('unit_price') ?? 0));
            }),
            TextInput::make('line_total')
            ->label('Total')
            ->numeric()
            ->prefix('EGP')
            ->readOnly()
            ->dehydrated(true)
            ->dehydrateStateUsing(fn (Get $get) =>
                round((float) ($get('qty') ?? 0) * (float) ($get('unit_price') ?? 0), 2)
            ),
        ]);
    }
}
