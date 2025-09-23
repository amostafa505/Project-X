<?php

namespace App\Filament\Central\Resources\Tenants\Tables;

use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('UUID')->copyable()->limit(8)->toggleable(true),

                TextColumn::make('code')->label('Code')
                    ->searchable()->copyable()
                    ->sortable(),

                TextColumn::make('name')->label('Name')
                    ->searchable()->sortable(),

                TextColumn::make('type')->label('Type')
                    ->badge()
                    ->color(fn ($state) => [
                        'school'   => 'info',
                        'clinic'   => 'success',
                        'pharmacy' => 'warning',
                    ][$state] ?? 'gray')
                    ->sortable(),

                TextColumn::make('plan')->label('Plan')->badge()
                    ->color(fn ($state) => [
                        'free' => 'gray',
                        'pro' => 'success',
                        'enterprise' => 'warning',
                    ][$state] ?? 'gray')
                    ->sortable(),

                TextColumn::make('status')->label('Status')->badge()
                    ->color(fn ($state) => [
                        'active'    => 'success',
                        'trial'     => 'info',
                        'suspended' => 'warning',
                        'cancelled' => 'danger',
                    ][$state] ?? 'gray')
                    ->sortable(),

                TextColumn::make('organization.name')->label('Organization')->searchable()->toggleable(true),
                TextColumn::make('owner.name')->label('Owner')->searchable()->toggleable(true),

                TextColumn::make('currency')->label('CCY')->alignCenter()->toggleable(true),
                TextColumn::make('locale')->label('Locale')->alignCenter()->toggleable(true),
                TextColumn::make('timezone')->label('TZ')->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('trial_ends_at')->label('Trial ends')->dateTime()->since()->sortable()
                    ->toggleable(true),

                TextColumn::make('created_at')->label('Created')->since()->sortable(),
                TextColumn::make('deleted_at')->label('Deleted')->since()->toggleable(true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'school' => 'School',
                        'clinic' => 'Clinic',
                        'pharmacy' => 'Pharmacy',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'trial' => 'Trial',
                        'suspended' => 'Suspended',
                        'cancelled' => 'Cancelled',
                    ]),
                SelectFilter::make('plan')
                    ->options([
                        'free' => 'Free',
                        'pro' => 'Pro',
                        'enterprise' => 'Enterprise',
                    ]),
                SelectFilter::make('organization_id')
                    ->relationship('organization', 'name')
                    ->label('Organization'),
                TrashedFilter::make(),
            ])
            ->modifyQueryUsing(function ($query) {
                return $query->with(['organization', 'owner']);
            })
            ->actions([
                Action::make('openApp')
                    ->label('Open App')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(function ($record) {
                        $host = $record->domains()->where('is_primary', true)->value('domain');
                        if (!$host) return null;

                        // لو المستخدم كاتب http/https في الدومين، سيبه زي ما هو
                        $hasScheme = (bool) preg_match('#^https?://#i', $host);

                        // اختَر السكيم: https للإنتاج، http لغيره
                        $scheme = app()->environment('production') ? 'https://' : 'http://';

                        $base = $hasScheme ? $host : $scheme . $host;

                        return rtrim($base, '/') . '/app';
                    }, shouldOpenInNewTab: true)
                    ->visible(fn ($record) => $record->domains()->exists()),
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),      // Soft delete
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }
}
