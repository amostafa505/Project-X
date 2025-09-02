<?php

namespace App\Filament\Tenant\Resources\Subjects\Schemas;

use App\Models\Branch;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Stancl\Tenancy\Database\Models\Domain;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        $tenantId = tenant()?->getKey()
        ?? Domain::query()->where('domain', request()->getHost())->value('tenant_id');
        return $schema
            ->components([
                Hidden::make('tenant_id')
                ->default(fn () => tenant('id')),
                Select::make('branch_id')
                ->label('Branch')
                ->required()
                ->searchable()
                ->preload()
                ->options(fn () =>
                    Branch::query()
                        ->where('tenant_id', $tenantId)
                        ->orderBy('name')
                        ->pluck('name', 'id')
                        ->toArray()
                )
                // حماية إضافية في الـ validation
                ->rule(
                    Rule::exists('branches', 'id')
                        ->where(fn ($q) => $q->where('tenant_id', $tenantId))
                ),
                TextInput::make('name')
                    ->required(),
                TextInput::make('code'),
            ]);
    }
}
