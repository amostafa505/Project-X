<?php

namespace App\Filament\Tenant\Resources\Doctors\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;

class DoctorsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(
                [
                    Grid::make(2)->schema([
                        TextInput::make('first_name')->label(__('First name'))->required(),
                        TextInput::make('last_name')->label(__('Last name')),
                        TextInput::make('email  ')->email(),
                        TextInput::make('phone'),
                        TextInput::make('specialty')->label(__('Specialty')),
                        TextInput::make('license_no')->label(__('License #')),
                        Toggle::make('is_active')->label(__('Active'))->default(true),
                    ])
                ]
            );
    }
}
