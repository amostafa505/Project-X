<?php

namespace App\Filament\Central\Resources\Organizations\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;

class OrganizationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('owner.name')->label('Owner')->searchable(),
                TextColumn::make('tenants_count')
                    ->label('Tenants')
                    ->counts('tenants') // requires withCount in query or automatic if supported
                    ->badge(),
                TextColumn::make('created_at')->label('Created')->since()->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                TrashedFilter::make()->hidden(), // لو مش بتستخدم SoftDeletes سيبه hidden
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->visible(fn () => auth()->user()->can('organizations.update')),
                    DeleteAction::make()
                        ->visible(fn () => auth()->user()->can('organizations.delete')),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()->can('organizations.delete')),
                ]),
            ])
            ->modifyQueryUsing(function ($query) {
                // مركزي: مفيش tenant_id هنا. بس نقدر نضمن withCount للـ tenants
                return $query->withCount('tenants');
            });
    }
}
