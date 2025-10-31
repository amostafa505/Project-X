<?php

namespace App\Filament\Tenant\Resources\Hospital\Encounters;

use App\Filament\Tenant\Resources\Hospital\Encounters\Pages\CreateEncounters;
use App\Filament\Tenant\Resources\Hospital\Encounters\Pages\EditEncounters;
use App\Filament\Tenant\Resources\Hospital\Encounters\Pages\ListEncounters;
use App\Filament\Tenant\Resources\Hospital\Encounters\Schemas\EncountersForm;
use App\Filament\Tenant\Resources\Hospital\Encounters\Tables\EncountersTable;
use App\Models\Hospital\Encounter;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EncountersResource extends Resource
{
    protected static ?string $model = Encounter::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static \UnitEnum|string|null  $navigationGroup = 'Hospital';
    protected static ?int $navigationSort = 50;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return EncountersForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EncountersTable::configure($table);
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
            'index' => ListEncounters::route('/'),
            'create' => CreateEncounters::route('/create'),
            'edit' => EditEncounters::route('/{record}/edit'),
        ];
    }
}
