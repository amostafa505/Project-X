<?php

namespace App\Filament\Tenant\Resources\Hospital\Departments\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class DepartmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Hidden::make('tenant_id')
                        ->default(fn () => tenant('id'))
                        ->dehydrated(true),
                    TextInput::make('name.en')->label('Name (EN)')->required(),
                    TextInput::make('name.ar')->label('الاسم (AR)'),
                    Textarea::make('description.en')->label('Description (EN)')->rows(2),
                    Textarea::make('description.ar')->label('الوصف (AR)')->rows(2),
                    TextInput::make('code')->maxLength(20),
                    Toggle::make('is_active')->label(__('Active'))->default(true),
                ])->columns(2),
            ]);
    }
}
