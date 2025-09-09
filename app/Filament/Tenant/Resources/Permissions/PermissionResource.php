<?php

namespace App\Filament\Tenant\Resources\Permissions;

use App\Filament\Tenant\Resources\Permissions\Pages\CreatePermission;
use App\Filament\Tenant\Resources\Permissions\Pages\EditPermission;
use App\Filament\Tenant\Resources\Permissions\Pages\ListPermissions;
use App\Filament\Tenant\Resources\Permissions\Schemas\PermissionForm;
use App\Filament\Tenant\Resources\Permissions\Tables\PermissionsTable;
use App\Models\Permission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::LockClosed;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 75;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PermissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermissionsTable::configure($table);
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
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
        ];
    }
}
