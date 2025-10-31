<?php

namespace App\Filament\Tenant\Resources\Departments;

use App\Filament\Tenant\Resources\Departments\Pages\CreateDepartments;
use App\Filament\Tenant\Resources\Departments\Pages\EditDepartments;
use App\Filament\Tenant\Resources\Departments\Pages\ListDepartments;
use App\Filament\Tenant\Resources\Departments\Schemas\DepartmentsForm;
use App\Filament\Tenant\Resources\Departments\Tables\DepartmentsTable;
use App\Models\Hospital\Department;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartmentsResource extends Resource
{
    protected static ?string $model = Department::class;
    protected static \UnitEnum|string|null $navigationGroup = 'Hospital';
    protected static ?int $navigationSort = 10;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DepartmentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepartmentsTable::configure($table);
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
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartments::route('/create'),
            'edit' => EditDepartments::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
