<?php

namespace App\Filament\Tenant\Resources\ClassRooms;

use App\Filament\Tenant\Resources\ClassRooms\Pages\CreateClassRoom;
use App\Filament\Tenant\Resources\ClassRooms\Pages\EditClassRoom;
use App\Filament\Tenant\Resources\ClassRooms\Pages\ListClassRooms;
use App\Filament\Tenant\Resources\ClassRooms\Schemas\ClassRoomForm;
use App\Filament\Tenant\Resources\ClassRooms\Tables\ClassRoomsTable;
use App\Models\Classroom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClassRoomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
     // مهم: مطابق لتوقيع الأب في v4
     protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
     protected static ?int $navigationSort = 20; // رقم لترتيب الظهور داخل المجموعة (اختياري)

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('tenant_id', tenant('id'));
    }
    public static function form(Schema $schema): Schema
    {
        return ClassRoomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassRoomsTable::configure($table);
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
            'index' => ListClassRooms::route('/'),
            'create' => CreateClassRoom::route('/create'),
            'edit' => EditClassRoom::route('/{record}/edit'),
        ];
    }
}
