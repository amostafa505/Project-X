<?php

namespace App\Filament\Tenant\Resources\FeeItems;

use App\Filament\Tenant\Resources\FeeItems\Pages\CreateFeeItem;
use App\Filament\Tenant\Resources\FeeItems\Pages\EditFeeItem;
use App\Filament\Tenant\Resources\FeeItems\Pages\ListFeeItems;
use App\Filament\Tenant\Resources\FeeItems\Schemas\FeeItemForm;
use App\Filament\Tenant\Resources\FeeItems\Tables\FeeItemsTable;
use App\Models\FeeItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FeeItemResource extends Resource
{
    protected static ?string $model = FeeItem::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Banknotes;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 55;

    public static function form(Schema $schema): Schema
    {
        return FeeItemForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return FeeItemsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFeeItems::route('/'),
            'create' => CreateFeeItem::route('/create'),
            'edit'   => EditFeeItem::route('/{record}/edit'),
        ];
    }
}
