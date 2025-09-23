<?php

namespace App\Filament\Central\Resources\Organizations\RelationManagers;

use Filament\Tables;
use App\Models\Branch;
use App\Models\Domain;
use App\Models\School;
use App\Models\Tenant;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\RelationManagers\RelationManager;

class TenantsRelationManager extends RelationManager
{
    protected static string $relationship = 'tenants';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        $orgId = $this->getOwnerRecord()->getKey();

        return $schema->schema([
            Hidden::make('organization_id')
                ->default($orgId)->dehydrated(true),

            Section::make('Identity')->columns(3)->schema([
                TextInput::make('code')
                    ->label('Code')->required()->maxLength(50)
                    ->regex('/^[A-Z0-9\-\._]+$/')
                    ->unique('tenants', 'code', ignoreRecord: true)
                    ->dehydrateStateUsing(fn ($v) => strtoupper(trim((string) $v))),

                TextInput::make('name')
                    ->label('Name')->required()->maxLength(150),

                Select::make('type')->label('Type')->options([
                    'school' => 'School',
                    'clinic' => 'Clinic',
                    'pharmacy' => 'Pharmacy',
                ])->default('school')->required(),
            ]),

            Section::make('Commercial & Locale')->columns(4)->schema([
                Select::make('plan')->label('Plan')->options([
                    'free' => 'Free', 'pro' => 'Pro', 'enterprise' => 'Enterprise',
                ])->default('free')->required(),

                TextInput::make('currency')->label('Currency')->default('EGP')
                    ->maxLength(3)->dehydrateStateUsing(fn ($s) => strtoupper(trim((string) $s)))
                    ->required(),

                Select::make('locale')->label('Locale')->options([
                    'ar' => 'Arabic', 'en' => 'English', 'fr' => 'French',
                ])->default('ar')->required(),

                TextInput::make('timezone')->label('Timezone')->default('Africa/Cairo')->required(),
            ]),

            Section::make('Lifecycle')->columns(3)->schema([
                Select::make('status')->label('Status')->options([
                    'active' => 'Active', 'trial' => 'Trial',
                    'suspended' => 'Suspended', 'cancelled' => 'Cancelled',
                ])->default('active')->required(),

                DateTimePicker::make('trial_ends_at')->seconds(false)->native(false),
                DateTimePicker::make('billing_starts_at')->seconds(false)->native(false),
            ]),

            Section::make('Config')->columns(2)->schema([
                KeyValue::make('data')->label('Data')->nullable()->addable()->editableKeys()->reorderable(),
                KeyValue::make('meta')->label('Meta')->nullable()->addable()->editableKeys()->reorderable(),
            ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['domains']))
            ->columns([
                TextColumn::make('code')->label('Code')->sortable()->searchable()->copyable(),
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('type')->badge()->sortable(),
                TextColumn::make('plan')->badge()->sortable(),
                TextColumn::make('status')->badge()->sortable(),
                TextColumn::make('domains_count')
                    ->counts('domains')->label('Domains')->badge(),
                TextColumn::make('created_at')->since()->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // UUID safeguard
                        $data['id'] = $data['id'] ?? (string) Str::uuid();
                        $data['code'] = strtoupper(trim((string) ($data['code'] ?? '')));
                        $data['currency'] = strtoupper(trim((string) ($data['currency'] ?? 'EGP')));
                        $data['locale']   = $data['locale']   ?? 'ar';
                        $data['timezone'] = $data['timezone'] ?? 'Africa/Cairo';
                        $data['plan']     = $data['plan']     ?? 'free';
                        $data['status']   = $data['status']   ?? 'active';
                        $data['data']     = $data['data']     ?? [];
                        $data['meta']     = $data['meta']     ?? [];
                        return $data;
                    }),
                CreateAction::make('addVertical')
                    ->label('Add Vertical')
                    ->icon('heroicon-o-building-library')
                    ->modalHeading('Create & Link Tenant (Vertical)')
                    ->form([
                        Select::make('type')
                            ->label('Type')
                            ->options([
                                'school'   => 'School',
                                'clinic'   => 'Clinic',
                                'pharmacy' => 'Pharmacy',
                            ])
                            ->required()
                            ->default('school'),

                        TextInput::make('name')
                            ->label('Tenant Name')
                            ->required()
                            ->maxLength(150),

                        TextInput::make('code')
                            ->label('Code (optional)')
                            ->helperText('If empty, a code like ORG-SCH-001 will be generated.')
                            ->maxLength(50),

                        Select::make('plan')
                            ->label('Plan')
                            ->options(['free' => 'Free', 'pro' => 'Pro', 'enterprise' => 'Enterprise'])
                            ->default('free')
                            ->required(),

                        TextInput::make('currency')
                            ->label('Currency')
                            ->default('EGP')
                            ->maxLength(3),

                        Select::make('locale')
                            ->label('Locale')
                            ->options(['ar' => 'Arabic', 'en' => 'English', 'fr' => 'French'])
                            ->default('ar'),

                        TextInput::make('timezone')
                            ->label('Timezone')
                            ->default('Africa/Cairo'),

                        TextInput::make('domain')
                            ->label('Primary Domain (optional)')
                            ->placeholder('tenant1.project-x.test')
                            ->helperText('Host only; leave empty to auto-build from code if base domain is configured.'),

                        Toggle::make('create_default_branch')
                            ->label('Create default branch')
                            ->default(true),

                        TextInput::make('branch_name')
                            ->label('Default branch name')
                            ->default('Main Branch')
                            ->maxLength(100)
                            ->visible(fn (callable $get) => (bool) $get('create_default_branch')),
                    ])
                    ->action(function (array $data) {
                        // 1) المنظمة الحالية
                        $org   = $this->getOwnerRecord();
                        $orgId = $org->getKey();

                        // 2) توليد/تأكيد الكود
                        $type = $data['type'];
                        $name = trim((string) ($data['name'] ?? ''));
                        $code = strtoupper(trim((string) ($data['code'] ?? '')));

                        if ($code === '') {
                            $orgSig = Str::upper(Str::slug((string) $org->name, '')); // ACME GROUP -> ACME-GROUP => A C M E GROUP -> "ACME-GROUP" then remove hyphen
                            $orgSig = preg_replace('/[^A-Z0-9]/', '', $orgSig) ?: 'ORG';

                            $typeSig = [
                                'school'   => 'SCH',
                                'clinic'   => 'CLI',
                                'pharmacy' => 'PHM',
                            ][$type] ?? Str::upper(substr($type, 0, 3));

                            $seq = Tenant::where('organization_id', $orgId)->where('type', $type)->count() + 1;
                            // تأكد من التفرد حتى لو اتغيّر العدد
                            do {
                                $code = sprintf('%s-%s-%03d', $orgSig, $typeSig, $seq);
                                $seq++;
                            } while (Tenant::where('code', $code)->exists());
                        }

                        // 3) السكيمات الافتراضية
                        $plan     = $data['plan']     ?? 'free';
                        $currency = strtoupper(trim((string) ($data['currency'] ?? 'EGP')));
                        $locale   = $data['locale']   ?? 'ar';
                        $timezone = $data['timezone'] ?? 'Africa/Cairo';

                        // 4) أنشئ التينانت
                        $tenantId = (string) Str::uuid();
                        $tenant = Tenant::create([
                            'id'               => $tenantId,
                            'organization_id'  => $orgId,
                            'code'             => $code,
                            'name'             => $name,
                            'type'             => $type,
                            'plan'             => $plan,
                            'currency'         => $currency,
                            'locale'           => $locale,
                            'timezone'         => $timezone,
                            'status'           => 'active',
                            'trial_ends_at'    => null,
                            'billing_starts_at' => null,
                            'data'             => [],
                            'meta'             => [],
                        ]);

                        // 5) Primary domain (اختياري) — لو مش مكتوب هنحاول نكوّنه تلقائيًا من الكود
                        $host = strtolower(trim((string) ($data['domain'] ?? '')));
                        if ($host === '') {
                            $base = config('tenancy.base_domain') ?? (config('tenancy.central_domains')[0] ?? null);
                            if ($base) {
                                $host = strtolower(str_replace('_', '-', Str::slug($code, '-'))) . '.' . strtolower($base);
                            }
                        }
                        if ($host !== '') {
                            Domain::updateOrCreate(
                                ['domain' => $host],
                                ['tenant_id' => $tenantId, 'is_primary' => true]
                            );
                        }

                        // 6) فرع افتراضي (اختياري)
                        if (!empty($data['create_default_branch'])) {
                            $branchName = trim((string) ($data['branch_name'] ?? 'Main Branch'));

                            // شغّل الكود داخل سياق التينانت الجديد عشان الـ FKs المطلوبة تبقى متاحة
                            $tenant->run(function () use ($type, $branchName) {
                                if ($type === 'school') {
                                    // 6.1 أنشئ مدرسة افتراضية بشكل آمن (بدون mass-assignment)
                                    $school = School::where('tenant_id', tenant('id'))
                                        ->where('name', 'Default School')
                                        ->first();

                                    if (!$school) {
                                        $school = new School();
                                        $school->tenant_id = tenant('id');
                                        $school->name = 'Default School';
                                        // لو عندك أعمدة REQUIRED تانية في schools ضيفها هنا قبل save()
                                        $school->save();
                                    }

                                    // 6.2 أنشئ فرع مربوط بالمدرسة الافتراضية (آمن برضه)
                                    $branchTitle = $branchName ?: 'Main Branch';

                                    $exists = Branch::where('tenant_id', tenant('id'))
                                        ->where('school_id', $school->id)
                                        ->where('name', $branchTitle)
                                        ->exists();

                                    if (!$exists) {
                                        $branch = new Branch();
                                        $branch->tenant_id = tenant('id');
                                        $branch->school_id = $school->id;
                                        $branch->name      = $branchTitle;
                                        // لو فيه أعمدة REQUIRED في branches (زي code/is_active/...) ضيفها هنا
                                        $branch->save();
                                    }
                                }

                                // TODO: لو عندك أنواع تانية (clinic/pharmacy) والفروع ليها موديل/علاقات مختلفة، حط منطقها هنا.
                            });
                        }
                    })
                    ->successNotificationTitle('Tenant created & linked to this Organization'),
            ])

            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
