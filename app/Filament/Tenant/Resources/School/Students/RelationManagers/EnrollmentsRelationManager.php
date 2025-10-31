<?php

namespace App\Filament\Tenant\Resources\School\Students\RelationManagers;

use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
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
            Hidden::make('tenant_id')
                ->default(fn () => (function_exists('tenant') && tenant()) ? tenant('id') : null)
                ->dehydrated(true),

            Select::make('classroom_id')
                ->label('Classroom')
                ->relationship('classroom', 'name')
                ->searchable()->preload()->required(),

            DatePicker::make('start_date')->required(),
            DatePicker::make('end_date'),
            Select::make('status')->options([
                'active'    => 'Active',
                'paused'    => 'Paused',
                'finished'  => 'Finished',
                'cancelled' => 'Cancelled',
            ])->required(),
        ]);
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // ضمان إضافي
        if (empty($data['tenant_id']) && function_exists('tenant') && tenant()) {
            $data['tenant_id'] = tenant('id');
        }
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // للـ Edit برضه
        if (empty($data['tenant_id']) && function_exists('tenant') && tenant()) {
            $data['tenant_id'] = tenant('id');
        }
        return $data;
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
