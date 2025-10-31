<?php

namespace App\Filament\Tenant\Resources\School\Schools;

use App\Filament\Tenant\Resources\School\Schools\Pages\CreateSchool;
use App\Filament\Tenant\Resources\School\Schools\Pages\EditSchool;
use App\Filament\Tenant\Resources\School\Schools\Pages\ListSchools;
use App\Filament\Tenant\Resources\School\Schools\Schemas\SchoolForm;
use App\Filament\Tenant\Resources\School\Schools\Tables\SchoolsTable;
use App\Models\School;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SchoolResource extends Resource
{
    protected static ?string $model = School::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    // مهم: مطابق لتوقيع الأب في v4
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 5; // رقم لترتيب الظهور داخل المجموعة (اختياري)

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SchoolForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SchoolsTable::configure($table);
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
            'index' => ListSchools::route('/'),
            'create' => CreateSchool::route('/create'),
            'edit' => EditSchool::route('/{record}/edit'),
        ];
    }
}
