<?php

namespace App\Filament\Tenant\Resources\Guardians\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class GuardianForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),
                TextInput::make('name')->required()->maxLength(100),
                TextInput::make('phone')->tel()->maxLength(30),
                TextInput::make('email')->email()->maxLength(150),
                TextInput::make('relation')->label('Relation')->maxLength(100),
                TextInput::make('national_id')->maxLength(50),
                Textarea::make('address')->rows(2),
            ]);
    }
}
