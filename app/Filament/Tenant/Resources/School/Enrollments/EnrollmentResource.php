<?php

namespace App\Filament\Tenant\Resources\School\Enrollments;

use App\Filament\Tenant\Resources\School\Enrollments\Pages\CreateEnrollment;
use App\Filament\Tenant\Resources\School\Enrollments\Pages\EditEnrollment;
use App\Filament\Tenant\Resources\School\Enrollments\Pages\ListEnrollments;
use App\Filament\Tenant\Resources\School\Enrollments\Schemas\EnrollmentForm;
use App\Filament\Tenant\Resources\School\Enrollments\Tables\EnrollmentsTable;
use App\Models\Enrollment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static ?int $navigationSort = 40;

    public static function form(Schema $schema): Schema
    {
        return EnrollmentForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return EnrollmentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListEnrollments::route('/'),
            'create' => CreateEnrollment::route('/create'),
            'edit'   => EditEnrollment::route('/{record}/edit'),
        ];
    }
}
