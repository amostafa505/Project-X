<?php

namespace App\Filament\Tenant\Resources\Doctors;

use App\Filament\Tenant\Resources\Doctors\Pages\CreateDoctors;
use App\Filament\Tenant\Resources\Doctors\Pages\EditDoctors;
use App\Filament\Tenant\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Tenant\Resources\Doctors\Schemas\DoctorsForm;
use App\Filament\Tenant\Resources\Doctors\Tables\DoctorsTable;
use App\Models\Hospital\Doctor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DoctorsResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $recordTitleAttribute = 'name';

    protected static \UnitEnum|string|null $navigationGroup = 'Hospital';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return DoctorsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table);
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
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctors::route('/create'),
            'edit' => EditDoctors::route('/{record}/edit'),
        ];
    }
}
