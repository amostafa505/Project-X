<?php

namespace App\Filament\Tenant\Resources\FeeItems\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FeeItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')->default(fn () => tenant('id'))->dehydrated(true),
                TextInput::make('name')->required()->maxLength(150),
                TextInput::make('code')->maxLength(50),
                TextInput::make('default_amount')->numeric()->prefix('EGP')->minValue(0),
                Textarea::make('description')->rows(2),
            ]);
    }
}
