<?php

namespace App\Filament\Tenant\Resources\School\Invoices\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),
                Select::make('student_id')
                    ->relationship('student', 'first_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('branch_id')
                    ->label('Branch')
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('number')->label('Invoice #')->maxLength(50),
                DatePicker::make('due_date')->native(false),
                Select::make('status')->options([
                    'draft'  => 'Draft',
                    'issued' => 'Issued',
                    'paid'   => 'Paid',
                    'overdue' => 'Overdue',
                    'void'   => 'Void',
                ])->default('draft'),
                TextInput::make('amount')->numeric()->prefix('EGP')->disabled(),
                Textarea::make('notes')->rows(2),
            ]);
    }
}
