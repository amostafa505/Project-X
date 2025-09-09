<?php

namespace App\Filament\Tenant\Resources\Enrollments\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.first_name')->label('Student')->searchable(),
                TextColumn::make('classRoom.name')->label('Classroom')->searchable(),
                TextColumn::make('school_year')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->since(),
            ])
            ->recordActions([ EditAction::make(), DeleteAction::make() ])
            ->toolbarActions([
                BulkActionGroup::make([ DeleteBulkAction::make() ]),
            ]);
    }
}
