<?php

namespace App\Filament\Tenant\Resources\Students\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Forms\Components\Hidden;
use Filament\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\RelationManagers\RelationManager;

class ClassroomsRelationManager extends RelationManager
{
    protected static string $relationship = 'classrooms'; // مطابق لاسم العلاقة في Student

    public function form(Schema $schema): Schema
    {
        // لو هتضيف فيوتشر pivot fields، حطها هنا.
        // للآن مش محتاجين غير tenant_id يتملّى تلقائيًا وقت الـ attach من الـ form.
        return $schema->components([
            Hidden::make('tenant_id')->default(fn () => tenant('id')),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Classroom')->searchable(),
                TextColumn::make('pivot.created_at')->since()->label('Linked'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form([
                        Hidden::make('tenant_id')->default(fn () => tenant('id')),
                    ]),
            ])
            ->actions([
                DetachAction::make(),
            ])
            ->bulkActions([
                DetachBulkAction::make(),
            ]);
    }
}
