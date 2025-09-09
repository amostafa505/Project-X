<?php

namespace App\Filament\Tenant\Resources\Guardians;

use App\Filament\Tenant\Resources\Guardians\Pages\CreateGuardian;
use App\Filament\Tenant\Resources\Guardians\Pages\EditGuardian;
use App\Filament\Tenant\Resources\Guardians\Pages\ListGuardians;
use App\Filament\Tenant\Resources\Guardians\Schemas\GuardianForm;
use App\Filament\Tenant\Resources\Guardians\Tables\GuardiansTable;
use App\Models\Guardian;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?string $modelLabel = 'Guardian';
    protected static ?string $pluralModelLabel = 'Guardians';

    public static function form(Schema $schema): Schema
    {
        return GuardianForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return GuardiansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            'edit'   => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }
}
