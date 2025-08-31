<?php

namespace App\Filament\Tenant\Resources;

use App\Filament\Concerns\TenantScopedResource; // لو single-DB
use App\Filament\Tenant\Resources\BranchResource\Pages;
use App\Models\Branch;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

class BranchResource extends Resource
{
    use TenantScopedResource; // علّقها لو multi-DB per tenant

    protected static ?string $model = Branch::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office';
    protected static \UnitEnum|string|null $navigationGroup = 'Organization';
    protected static ?string $modelLabel = 'Branch';
    protected static ?string $pluralModelLabel = 'Branches';

    public static function form(Schema $schema): Schema
{
    return $schema->components([
        Forms\Components\Section::make('Basic Info')
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('code')->maxLength(50),
                Forms\Components\TextInput::make('phone')->tel(),
            ])->columns(2),
    ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('school.name')
                    ->label('School')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('school_id')
                    ->label('School')
                    ->relationship('school','name'),
                Tables\Filters\TrashedFilter::make(), // شغّال لو الموديل بيستخدم SoftDeletes
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth(MaxWidth::Large),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id','desc');
    }

    public static function getRelations(): array
    {
        return [
            // Relation managers هنا (مثلاً SubjectsRelationManager) لو تحب تضيفه لاحقًا
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit'   => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
