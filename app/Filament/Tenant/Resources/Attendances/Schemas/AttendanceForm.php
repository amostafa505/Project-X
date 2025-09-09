<?php

namespace App\Filament\Tenant\Resources\Attendance\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),
                Select::make('branch_id')
                ->relationship('branch', 'name')
                ->searchable()->preload()->required(),
                Select::make('student_id')
                ->relationship('student', 'first_name')
                ->searchable()->preload()->required(),
                Select::make('status')->options([
                    'present' => 'Present',
                    'absent'  => 'Absent',
                    'late'    => 'Late',
                    'excused' => 'Excused',
                    ])->default('present')->required(),
                DatePicker::make('date')->required()->native(false),
                Textarea::make('note')->rows(2),
            ]);
    }
}
