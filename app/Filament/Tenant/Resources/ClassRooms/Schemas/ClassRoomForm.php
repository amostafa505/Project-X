<?php

namespace App\Filament\Tenant\Resources\ClassRooms\Schemas;

use App\Models\Branch;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ClassRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('tenant_id')
                    ->default(fn () => tenant('id'))
                    ->dehydrated(true),

                    Select::make('branch_id')
                    ->label('Branch')
                    ->options(function () {
                        $q = Branch::query();
                        // لو بتستخدم stancl BelongsToTenant في Branch، مش محتاج where
                        if (function_exists('tenant') && tenant('id')) {
                            $q->where('tenant_id', tenant('id'));
                        }
                        return $q->orderBy('name')->pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->rule('exists:branches,id'),

                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(100),

                TextInput::make('grade')
                    ->label('Grade')
                    ->maxLength(20),

                TextInput::make('section')
                    ->label('Section')
                    ->maxLength(20),
            ])
            ->columns(2);
    }
}
