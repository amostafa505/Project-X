<?php

namespace App\Filament\Tenant\Widgets;

use Filament\Tables;
use App\Models\Invoice;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentInvoices extends BaseWidget
{
    protected Static ?string $heading = 'Recent Invoices';
    protected static ?int $sort = 2; // Widget::$sort غالبًا static عندك

    // مصدر البيانات (لا تحط ->limit هنا؛ هنظبط العرض من خصائص الجدول)
    protected function getTableQuery(): Builder
    {
        return Invoice::query()
            ->where('tenant_id', tenant('id'))
            ->latest('created_at');
    }

    // الأعمدة
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('number')
                ->label('No.')
                ->searchable(),

            Tables\Columns\TextColumn::make('student.first_name')
                ->label('Student')
                ->formatStateUsing(fn ($record) =>
                    trim(($record->student->first_name ?? '') . ' ' . ($record->student->last_name ?? ''))
                )
                ->searchable(),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->colors([
                    'success' => 'paid',
                    'warning' => 'pending',
                    'danger'  => 'unpaid',
                ]),

            Tables\Columns\TextColumn::make('amount')
                ->label('Total')
                ->money('egp', true),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Issue Date')
                ->date(),
        ];
    }

    // أزرار السطر (اختياري)
    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->visible(fn () => auth()->user()->can('invoices.view')),
            EditAction::make()
                ->visible(fn () => auth()->user()->can('invoices.update')),
        ];
    }

    // حجم الصفحة الافتراضي (بدل ما نعمل ->limit في الـ query)
    protected function getDefaultTableRecordsPerPage(): int
    {
        return 10;
    }
}
