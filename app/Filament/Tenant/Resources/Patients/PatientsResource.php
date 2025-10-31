<?php

namespace App\Filament\Tenant\Resources\Patients;

use App\Filament\Tenant\Resources\Patients\Pages\CreatePatients;
use App\Filament\Tenant\Resources\Patients\Pages\EditPatients;
use App\Filament\Tenant\Resources\Patients\Pages\ListPatients;
use App\Filament\Tenant\Resources\Patients\Schemas\PatientsForm;
use App\Filament\Tenant\Resources\Patients\Tables\PatientsTable;
use App\Models\Hospital\Patient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PatientsResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static \UnitEnum|string|null $navigationGroup = 'Hospital';
    protected static ?int $navigationSort = 30;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PatientsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientsTable::configure($table);
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
            'index' => ListPatients::route('/'),
            'create' => CreatePatients::route('/create'),
            'edit' => EditPatients::route('/{record}/edit'),
        ];
    }
}
