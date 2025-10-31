<?php

namespace App\Filament\Tenant\Resources\School\Subjects\Schemas;

use App\Models\Branch;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Support\Tenancy;


class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        $tenantId = Tenancy::id();
        return $schema
            ->components([

                Hidden::make('tenant_id')
                    ->default(fn () => tenant('id')),

                Select::make('branch_id')
                    ->label('Branch')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->options(
                        fn () =>
                        Branch::query()
                            ->where('tenant_id', $tenantId)
                            ->orderBy('name')
                            ->pluck('name', 'id')->toArray()
                    )
                    ->rule(Rule::exists('branches', 'id')->where('tenant_id', $tenantId)),

                TextInput::make('name')
                    ->required(),
                TextInput::make('code'),
            ]);
    }
}
