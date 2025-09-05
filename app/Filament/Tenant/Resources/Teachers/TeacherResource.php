<?php

namespace App\Filament\Tenant\Resources\Teachers;

use App\Models\Teacher;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Tenant\Resources\Teachers\Pages\EditTeacher;
use App\Filament\Tenant\Resources\Teachers\Pages\ListTeachers;
use App\Filament\Tenant\Resources\Teachers\Pages\CreateTeacher;
use App\Filament\Tenant\Resources\Teachers\Schemas\TeacherForm;
use App\Filament\Tenant\Resources\Teachers\Tables\TeachersTable;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 25;
    // Navigation
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $modelLabel       = 'Teacher';
    protected static ?string $pluralModelLabel = 'Teachers';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone', 'employee_code', 'specialization'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'Email' => $record->email,
            'Phone' => $record->phone,
            'Code'  => $record->employee_code,
        ];
    }

    // Filament v4 Schemas API
    public static function form(Schema $schema): Schema
    {
        return TeacherForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeachersTable::configure($table);
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
            'index'  => ListTeachers::route('/'),
            'create' => CreateTeacher::route('/create'),
            'edit'   => EditTeacher::route('/{record}/edit'),
        ];
    }
}
