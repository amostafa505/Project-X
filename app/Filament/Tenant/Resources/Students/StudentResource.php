<?php

namespace App\Filament\Tenant\Resources\Students;

use App\Filament\Tenant\Resources\Students\Pages\CreateStudent;
use App\Filament\Tenant\Resources\Students\Pages\EditStudent;
use App\Filament\Tenant\Resources\Students\Pages\ListStudents;
use App\Filament\Tenant\Resources\Students\Schemas\StudentForm;
use App\Filament\Tenant\Resources\Students\Tables\StudentsTable;
use App\Models\Student;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    // مهم: مطابق لتوقيع الأب في v4
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 25; // رقم لترتيب الظهور داخل المجموعة (اختياري)


    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StudentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\EnrollmentsRelationManager::class,
            RelationManagers\ClassRoomsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}
