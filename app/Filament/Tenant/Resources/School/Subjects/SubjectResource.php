<?php

namespace App\Filament\Tenant\Resources\School\Subjects;

use App\Filament\Tenant\Resources\School\Subjects\Pages\CreateSubject;
use App\Filament\Tenant\Resources\School\Subjects\Pages\EditSubject;
use App\Filament\Tenant\Resources\School\Subjects\Pages\ListSubjects;
use App\Filament\Tenant\Resources\School\Subjects\Schemas\SubjectForm;
use App\Filament\Tenant\Resources\School\Subjects\Tables\SubjectsTable;
use App\Models\Subject;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    // مهم: مطابق لتوقيع الأب في v4
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 15; // رقم لترتيب الظهور داخل المجموعة (اختياري)

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SubjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubjectsTable::configure($table);
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
            'index' => ListSubjects::route('/'),
            'create' => CreateSubject::route('/create'),
            'edit' => EditSubject::route('/{record}/edit'),
        ];
    }
}
