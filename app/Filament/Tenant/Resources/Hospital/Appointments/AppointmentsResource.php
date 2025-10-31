<?php

namespace App\Filament\Tenant\Resources\Hospital\Hospital\Appointments;

use App\Filament\Tenant\Resources\Hospital\Appointments\Pages\CreateAppointments;
use App\Filament\Tenant\Resources\Hospital\Appointments\Pages\EditAppointments;
use App\Filament\Tenant\Resources\Hospital\Appointments\Pages\ListAppointments;
use App\Filament\Tenant\Resources\Hospital\Appointments\Schemas\AppointmentsForm;
use App\Filament\Tenant\Resources\Hospital\Appointments\Tables\AppointmentsTable;
use App\Models\Hospital\Appointment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AppointmentsResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static \UnitEnum|string|null $navigationGroup = 'Hospital';
    protected static ?int $navigationSort = 40;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AppointmentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentsTable::configure($table);
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
            'index' => ListAppointments::route('/'),
            'create' => CreateAppointments::route('/create'),
            'edit' => EditAppointments::route('/{record}/edit'),
        ];
    }
}
