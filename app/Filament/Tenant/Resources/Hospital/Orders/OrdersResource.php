<?php

namespace App\Filament\Tenant\Resources\Hospital\Order;

use App\Filament\Tenant\Resources\Hospital\Order\Pages\CreateOrder;
use App\Filament\Tenant\Resources\Hospital\Order\Pages\EditOrder;
use App\Filament\Tenant\Resources\Hospital\Order\Pages\ListOrder;
use App\Filament\Tenant\Resources\Hospital\Order\Schemas\OrderForm;
use App\Filament\Tenant\Resources\Hospital\Order\Tables\OrderTable;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrderTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrder::route('/'),
            'create' => CreateOrder::route('/create'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }
}
