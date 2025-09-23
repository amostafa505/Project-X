<?php

namespace App\Filament\Central\Resources\Domains;

use App\Filament\Central\Resources\Domains\Pages\CreateDomain;
use App\Filament\Central\Resources\Domains\Pages\EditDomain;
use App\Filament\Central\Resources\Domains\Pages\ListDomains;
use App\Filament\Central\Resources\Domains\Schemas\DomainForm;
use App\Filament\Central\Resources\Domains\Tables\DomainsTable;
use App\Models\Domain;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DomainResource extends Resource
{
    protected static ?string $model = Domain::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::GlobeAlt;
    protected static \UnitEnum|string|null  $navigationGroup = 'Multitenancy';
    protected static ?string $modelLabel = 'Domain';
    protected static ?string $pluralModelLabel = 'Domains';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return DomainForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DomainsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDomains::route('/'),
            'create' => CreateDomain::route('/create'),
            'edit' => EditDomain::route('/{record}/edit'),
        ];
    }
}
