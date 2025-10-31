<?php

namespace App\Filament\Tenant\Resources\Hospital\Order\Schemas;

use Filament\Schemas\Schema;
use App\Models\Hospital\Doctor;
use App\Models\Hospital\Patient;
use App\Models\Hospital\Department;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Order Details'))
                    ->schema([
                        Select::make('type')
                            ->label(__('Order Type'))
                            ->options([
                                'lab' => __('Lab Order'),
                                'imaging' => __('Imaging Order'),
                                'pharmacy' => __('Pharmacy Order'),
                            ])
                            ->native(false)
                            ->required(),

                        Select::make('patient_id')
                            ->label(__('Patient'))
                            ->relationship('patient', 'first_name')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelUsing(
                                fn ($value) =>
                                optional(Patient::find($value))?->full_name ?? ''
                            )
                            ->required(),

                        Select::make('doctor_id')
                            ->label(__('Doctor'))
                            ->relationship('doctor', 'first_name')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelUsing(
                                fn ($value) =>
                                optional(Doctor::find($value))?->full_name ?? ''
                            ),

                        Select::make('encounter_id')
                            ->label(__('Encounter'))
                            ->relationship('encounter', 'id')
                            ->searchable()
                            ->preload(),

                        Select::make('department_id')
                            ->label(__('Department'))
                            ->relationship('department', 'name')
                            ->getOptionLabelUsing(
                                fn ($value) =>
                                optional(Department::find($value))?->getTranslation('name', app()->getLocale()) ?? ''
                            ),

                        DateTimePicker::make('ordered_at')
                            ->label(__('Ordered At'))
                            ->default(now()),
                    ])->columns(2),

                Section::make(__('Content'))
                    ->schema([
                        TextInput::make('title.en')->label(__('Title (EN)'))->required(),
                        TextInput::make('title.ar')->label(__('Title (AR)')),

                        Textarea::make('description.en')->label(__('Description (EN)'))->rows(2),
                        Textarea::make('description.ar')->label(__('Description (AR)'))->rows(2),

                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'requested' => __('Requested'),
                                'in_progress' => __('In Progress'),
                                'completed' => __('Completed'),
                                'canceled' => __('Canceled'),
                            ])
                            ->default('requested')
                            ->native(false),
                    ])->columns(2),

                Section::make(__('Order Items'))
                    ->schema([
                        Repeater::make('items')
                            ->label(__('Items'))
                            ->relationship()
                            ->schema([
                                Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        'lab' => __('Lab'),
                                        'imaging' => __('Imaging'),
                                        'pharmacy' => __('Pharmacy'),
                                    ])
                                    ->default(fn (Get $get) => $get('../../type'))
                                    ->required(),

                                TextInput::make('name.en')->label(__('Name (EN)'))->required(),
                                TextInput::make('name.ar')->label(__('Name (AR)')),

                                TextInput::make('code')->label(__('Code'))->columnSpan(1),
                                TextInput::make('unit')->label(__('Unit'))->columnSpan(1),
                                TextInput::make('quantity')->numeric()->label(__('Quantity'))->columnSpan(1),
                                TextInput::make('price')->numeric()->label(__('Price'))->columnSpan(1),

                                Textarea::make('description.en')->label(__('Description (EN)'))->rows(2)->columnSpanFull(),
                                Textarea::make('description.ar')->label(__('Description (AR)'))->rows(2)->columnSpanFull(),

                                Textarea::make('result.en')->label(__('Result (EN)'))->rows(2)->columnSpanFull(),
                                Textarea::make('result.ar')->label(__('Result (AR)'))->rows(2)->columnSpanFull(),

                                Textarea::make('notes.en')->label(__('Notes (EN)'))->rows(2)->columnSpanFull(),
                                Textarea::make('notes.ar')->label(__('Notes (AR)'))->rows(2)->columnSpanFull(),
                            ])
                            ->defaultItems(1)
                            ->columns(2)
                            ->collapsed()
                            ->reorderable()
                            ->addActionLabel(__('Add Item')),
                    ]),

                Section::make(__('Results & Notes'))
                    ->schema([
                        Textarea::make('results.en')->label(__('Results (EN)'))->rows(2),
                        Textarea::make('results.ar')->label(__('Results (AR)'))->rows(2),

                        Textarea::make('notes.en')->label(__('Notes (EN)'))->rows(2),
                        Textarea::make('notes.ar')->label(__('Notes (AR)'))->rows(2),

                        DateTimePicker::make('completed_at')->label(__('Completed At')),
                    ])->columns(2),
            ]);
    }
}
