<?php

namespace App\Filament\Tenant\Resources\Enrollments;

use App\Filament\Tenant\Resources\Enrollments\Pages\CreateEnrollment;
use App\Filament\Tenant\Resources\Enrollments\Pages\EditEnrollment;
use App\Filament\Tenant\Resources\Enrollments\Pages\ListEnrollments;
use App\Filament\Tenant\Resources\Enrollments\Schemas\EnrollmentForm;
use App\Filament\Tenant\Resources\Enrollments\Tables\EnrollmentsTable;
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
            'index'  => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
            'edit'   => Pages\EditEnrollment::route('/{record}/edit'),
        ];
    }
}
