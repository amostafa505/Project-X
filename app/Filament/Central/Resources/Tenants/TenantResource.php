<?php

namespace App\Filament\Central\Resources\Tenants;

use App\Filament\Central\Resources\Tenants\Pages\CreateTenant;
use App\Filament\Central\Resources\Tenants\Pages\EditTenant;
use App\Filament\Central\Resources\Tenants\Pages\ListTenants;
use App\Filament\Central\Resources\Tenants\Schemas\TenantForm;
use App\Filament\Central\Resources\Tenants\Tables\TenantsTable;
use App\Models\Tenant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;
    protected static \UnitEnum|string|null  $navigationGroup = 'Multitenancy';
    protected static ?string $modelLabel = 'Tenant';
    protected static ?string $pluralModelLabel = 'Tenants';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TenantForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return TenantsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListTenants::route('/'),
            'create' => CreateTenant::route('/create'),
            'edit'   => EditTenant::route('/{record}/edit'),
        ];
    }
}
