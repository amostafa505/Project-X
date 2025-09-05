<?php

namespace App\Filament\Tenant\Resources\Branches;

use Filament\Forms;
use Filament\Tables;
use App\Models\Branch;
use App\Models\School;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Support\Tenancy;


class BranchResource extends Resource
{
    // مهم: مطابق لتوقيع الأب في v4
    protected static \UnitEnum|string|null  $navigationGroup = 'Organization';
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 10; // رقم لترتيب الظهور داخل المجموعة (اختياري)

    protected static ?string $model = Branch::class;
    protected static ?string $modelLabel = 'Branch';
    protected static ?string $pluralModelLabel = 'Branches';
    // (اختياري) لو عايز سلاج مخصص:
    // protected static ?string $slug = 'branches';

    // v4: Schema بدلاً من Forms\Form
    public static function form(Schema $schema): Schema
    {
        $tenantId = Tenancy::id();

        return $schema->components([
            Section::make('Basic Info')
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('code')
                        ->label('Code')
                        ->maxLength(50),

                    TextInput::make('phone')
                        ->label('Phone')
                        ->tel()
                        ->maxLength(50),

                    Textarea::make('address')
                        ->label('Address')
                        ->rows(3),

                    Hidden::make('tenant_id')
                    ->default(fn () => tenant('id')),

                    Select::make('school_id')
                    ->label('School')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->options(fn() =>
                        School::query()
                            ->where('tenant_id', $tenantId)
                            ->orderBy('name')
                            ->pluck('name','id')->toArray()
                    )
                    ->rule(Rule::exists('schools','id')->where('tenant_id',$tenantId))

                ])
                ->columns(2),
        ]);
    }

    // v4: Table كما هو (تأكد من use Table)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('school.name')
                ->label('School')
                ->searchable()
                ->sortable(),

                TextColumn::make('code')
                    ->label('Code')
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Phone')
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->since()
                    ->label('Created'),
            ])
            ->filters([
                //
            ])
            // لو حصل تصادم في v4 عندك، بدّل actions() إلى recordActions()
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    // صفحات الريسورس
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit'   => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
