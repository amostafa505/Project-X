<?php

namespace App\Filament\Tenant\Resources\Invoices\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\ExportAction;

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
                ExportAction::make()
                    ->label('Export')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable() // يقرأ نفس البيانات والفلاتر من الجدول
                            ->withColumns([
                                Column::make('number')->heading('Invoice #'),
                                Column::make('student.first_name')->heading('Student'),
                                Column::make('due_date')
                                    ->heading('Due Date')
                                    ->formatStateUsing(fn ($state) => optional(\Illuminate\Support\Carbon::parse($state))->format('Y-m-d')),
                                Column::make('status')->heading('Status'),
                                Column::make('amount')->heading('Amount'),
                            ])
                            ->askForWriterType()
                            ->withFilename('invoices-' . now()->format('Ymd-His')),
                    ]),
            ])
            ->filters([
                // الحالة
                SelectFilter::make('status')
                    ->options([
                        'paid'    => 'Paid',
                        'pending' => 'Pending',
                        'unpaid'  => 'Unpaid',
                    ])
                    ->label('Status'),

                // نطاق تاريخ الإصدار
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('to')->label('To'),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) $indicators[] = 'From: ' . $data['from'];
                        if ($data['to'] ?? null)   $indicators[] = 'To: '   . $data['to'];
                        return $indicators;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn ($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['to']   ?? null, fn ($q, $d) => $q->whereDate('created_at', '<=', $d));
                    })
                    ->label('Issue Date'),

                // نطاق المبلغ
                Filter::make('amount_range')
                    ->form([
                        TextInput::make('min')->numeric()->label('Min'),
                        TextInput::make('max')->numeric()->label('Max'),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $ind = [];
                        if ($data['min'] ?? null) $ind[] = 'Min: ' . $data['min'];
                        if ($data['max'] ?? null) $ind[] = 'Max: ' . $data['max'];
                        return $ind;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['min'] ?? null, fn ($q, $v) => $q->where('amount', '>=', (float) $v))
                            ->when($data['max'] ?? null, fn ($q, $v) => $q->where('amount', '<=', (float) $v));
                    })
                    ->label('Amount'),

                // الطالب (علاقة)
                SelectFilter::make('student_id')
                    ->relationship('student', 'first_name', fn ($query) => $query->where('tenant_id', tenant('id')))
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => trim(($record->first_name ?? '') . ' ' . ($record->last_name ?? '')))
                    ->label('Student'),
            ]);
    }
}
