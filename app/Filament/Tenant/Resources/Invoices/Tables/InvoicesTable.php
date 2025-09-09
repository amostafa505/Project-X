<?php

namespace App\Filament\Tenant\Resources\Invoices\Tables;

use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Invoice #')->searchable(),
                TextColumn::make('student.first_name')->label('Student')->searchable(),
                TextColumn::make('created_at')->Label('Issue Date')->since(),
                TextColumn::make('due_date')->date(),
                TextColumn::make('status')->badge(),
                TextColumn::make('amount')->money('egp', true),
            ])
            ->actions([
                EditAction::make()
                    ->visible(fn () => auth()->user()->can('invoices.update')),
                DeleteAction::make()
                    ->visible(fn () => auth()->user()->can('invoices.delete')),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn () => auth()->user()->can('invoices.create')),
            ])
            ->recordActions([ EditAction::make(), DeleteAction::make() ])
            ->toolbarActions([
                BulkActionGroup::make([ DeleteBulkAction::make() ]),
            ]);
    }
}
