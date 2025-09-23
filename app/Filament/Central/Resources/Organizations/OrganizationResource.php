<?php

namespace App\Filament\Central\Resources\Organizations;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\Organization;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Central\Resources\Organizations\Pages\EditOrganization;
use App\Filament\Central\Resources\Organizations\Pages\ListOrganizations;
use App\Filament\Central\Resources\Organizations\Pages\CreateOrganization;
use App\Filament\Central\Resources\Organizations\Schemas\OrganizationForm;
use App\Filament\Central\Resources\Organizations\Tables\OrganizationsTable;
use App\Filament\Central\Resources\Organizations\RelationManagers\TenantsRelationManager;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;
    protected static \UnitEnum|string|null  $navigationGroup = 'Administration';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return OrganizationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TenantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizations::route('/'),
            'create' => CreateOrganization::route('/create'),
            'edit' => EditOrganization::route('/{record}/edit'),
        ];
    }
}
