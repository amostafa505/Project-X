<?php

namespace App\Filament\Tenant\Resources\School\Invoices;

use BackedEnum;
use App\Models\Invoice;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Tenant\Resources\School\Invoices\RelationManagers\InvoiceItemsRelationManager;
use App\Filament\Tenant\Resources\School\Invoices\Pages\EditInvoice;
use App\Filament\Tenant\Resources\School\Invoices\Pages\ListInvoices;
use App\Filament\Tenant\Resources\School\Invoices\Pages\CreateInvoice;
use App\Filament\Tenant\Resources\School\Invoices\Schemas\InvoiceForm;
use App\Filament\Tenant\Resources\School\Invoices\Tables\InvoicesTable;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 60;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InvoiceForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return InvoicesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            InvoiceItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListInvoices::route('/'),
            'create' => CreateInvoice::route('/create'),
            'edit'   => EditInvoice::route('/{record}/edit'),
        ];
    }
}
