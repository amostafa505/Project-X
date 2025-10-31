<?php

namespace App\Filament\Tenant\Resources\Hospital\LabTests;

use App\Filament\Tenant\Resources\Hospital\LabTests\Pages\CreateLabTests;
use App\Filament\Tenant\Resources\Hospital\LabTests\Pages\EditLabTests;
use App\Filament\Tenant\Resources\Hospital\LabTests\Pages\ListLabTests;
use App\Filament\Tenant\Resources\Hospital\LabTests\Schemas\LabTestsForm;
use App\Filament\Tenant\Resources\Hospital\LabTests\Tables\LabTestsTable;
use App\Models\Hospital\LabTests;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LabTestsResource extends Resource
{
    protected static ?string $model = LabTests::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-beaker';
    protected static \UnitEnum|string|null  $navigationGroup = 'Hospital';
    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LabTestsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LabTestsTable::configure($table);
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
            'index' => ListLabTests::route('/'),
            'create' => CreateLabTests::route('/create'),
            'edit' => EditLabTests::route('/{record}/edit'),
        ];
    }
}
