<?php

namespace App\Filament\Tenant\Resources\Students\Tables;

use App\Models\Student;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Tenant\Traits\BranchScoped;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name')
                    ->getStateUsing(fn (Student $r) => trim($r->first_name . ' ' . $r->last_name))
                    ->searchable(query: function (Builder $query, string $search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),

                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('school.name')
                    ->label('School')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('guardian.name')
                    ->label('Guardian')
                    ->toggleable(),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'male' => 'Male',
                        'female' => 'Female',
                        default => '—',
                    })
                    ->color(fn ($state) => $state === 'm' ? 'info' : ($state === 'f' ? 'success' : 'gray')),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => [
                        'active'    => 'success',
                        'inactive'  => 'gray',
                        'suspended' => 'warning',
                    ][$state] ?? 'gray'),

                TextColumn::make('dob')
                    ->label('DOB')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('school')
                    ->relationship('school', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('branch')
                    ->relationship('branch', 'name')
                    ->preload()
                    ->searchable(),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active'    => 'Active',
                        'inactive'  => 'Inactive',
                        'suspended' => 'Suspended',
                    ]),

                SelectFilter::make('gender')
                    ->label('Gender')
                    ->options([
                        'm' => 'Male',
                        'f' => 'Female',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
        return BranchScoped::scopeTenantBranch($table);
    }
}
