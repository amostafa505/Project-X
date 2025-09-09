<?php

namespace App\Filament\Tenant\Resources\Attendance\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class AttendanceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->date(),
                TextColumn::make('student.first_name')->label('Student')->searchable(),
                TextColumn::make('status')->badge(),
                TextColumn::make('note')->limit(30)->toggleable(),
                TextColumn::make('created_at')->since(),
            ])
            ->recordActions([ EditAction::make(), DeleteAction::make() ])
            ->toolbarActions([
                BulkActionGroup::make([ DeleteBulkAction::make() ]),
            ]);
    }
}
