<?php

namespace App\Filament\Tenant\Resources\School\Guardians;

use App\Filament\Tenant\Resources\School\Guardians\Pages\CreateGuardian;
use App\Filament\Tenant\Resources\School\Guardians\Pages\EditGuardian;
use App\Filament\Tenant\Resources\School\Guardians\Pages\ListGuardians;
use App\Filament\Tenant\Resources\School\Guardians\Schemas\GuardianForm;
use App\Filament\Tenant\Resources\School\Guardians\Tables\GuardiansTable;
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
            'index'  => ListGuardians::route('/'),
            'create' => CreateGuardian::route('/create'),
            'edit'   => EditGuardian::route('/{record}/edit'),
        ];
    }
}
