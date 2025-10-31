<?php

namespace App\Filament\Tenant\Resources\School\Enrollments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),

                Select::make('student_id')
                    ->relationship('student', 'first_name')
                    ->searchable()->preload()->required(),
                Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->searchable()->preload()->required(),
                Select::make('status')
                    ->options([
                        'active'    => 'Active',
                        'completed' => 'Completed',
                        'withdrawn' => 'Withdrawn',
                    ])->default('active'),
                DatePicker::make('start_date')->native(false),
                DatePicker::make('end_date')->native(false),
            ]);
    }
}
