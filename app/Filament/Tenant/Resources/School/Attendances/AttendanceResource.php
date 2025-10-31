<?php

namespace App\Filament\Tenant\Resources\School\Attendances;

use App\Filament\Tenant\Resources\School\Attendances\Pages\CreateAttendance;
use App\Filament\Tenant\Resources\School\Attendances\Pages\EditAttendance;
use App\Filament\Tenant\Resources\School\Attendances\Pages\ListAttendances;
use App\Filament\Tenant\Resources\School\Attendance\Schemas\AttendanceForm;
use App\Filament\Tenant\Resources\School\Attendance\Tables\AttendanceTable;
use App\Models\Attendance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckCircle;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 50;
    protected static ?string $modelLabel = 'Attendance';
    protected static ?string $pluralModelLabel = 'Attendances';

    public static function form(Schema $schema): Schema
    {
        return AttendanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AttendanceTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAttendances::route('/'),
            'create' => CreateAttendance::route('/create'),
            'edit'   => EditAttendance::route('/{record}/edit'),
        ];
    }
}
