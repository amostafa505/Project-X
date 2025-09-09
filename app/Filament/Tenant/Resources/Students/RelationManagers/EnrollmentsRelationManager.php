<?php

namespace App\Filament\Tenant\Resources\Students\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\RelationManagers\RelationManager;

class EnrollmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'enrollments'; // مطابق لاسم الميثود في Student

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('classroom_id')
                ->label('Classroom')
                ->relationship('classroom', 'name') // App\Models\Enrollment::classroom()
                ->searchable()->preload()->required(),

            DatePicker::make('start_date')->required(),
            DatePicker::make('end_date'),

            Select::make('status')
                ->options([
                    'active'    => 'Active',
                    'paused'    => 'Paused',
                    'finished'  => 'Finished',
                    'cancelled' => 'Cancelled',
                ])
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('classroom.name')->label('Classroom')->searchable(),
                TextColumn::make('start_date')->date(),
                TextColumn::make('end_date')->date(),
                TextColumn::make('status')->badge(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
