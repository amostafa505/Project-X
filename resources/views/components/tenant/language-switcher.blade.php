@php
    $current = app()->getLocale();
    $currentLabel = strtoupper($current === 'ar' ? 'AR' : 'EN'); // fallback EN
@endphp

<div class="hidden sm:flex items-center rtl:flex-row-reverse"
    @if ($current === 'en') style="margin-left: 5px" @endif
    @if ($current === 'ar') style="margin-right: 5px" @endif>
    <x-filament::dropdown placement="bottom-end" teleport>
        <x-slot name="trigger">
            <x-filament::button size="sm" color="gray" icon="heroicon-m-language" :label="$currentLabel"
                class="!rounded-full" />
        </x-slot>

        <x-filament::dropdown.list class="min-w-40">
            {{-- <x-filament::dropdown.list.item tag="a" :href="route('set-locale', ['locale' => 'en'])" icon="heroicon-m-flag" :color="$current === 'en' ? 'primary' : 'gray'">
                <div class="flex items-center justify-between w-full">
                    <span>English</span>
                    @if ($current === 'en')
                        <x-filament::icon icon="heroicon-m-check" class="h-4 w-4" />
                    @endif
                </div>
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item tag="a" :href="route('set-locale', ['locale' => 'ar'])" icon="heroicon-m-flag" :color="$current === 'ar' ? 'primary' : 'gray'">
                <div class="flex items-center justify-between w-full">
                    <span>العربية</span>
                    @if ($current === 'ar')
                        <x-filament::icon icon="heroicon-m-check" class="h-4 w-4" />
                    @endif
                </div>
            </x-filament::dropdown.list.item> --}}
            @php
                $current = app()->getLocale();
            @endphp

            <x-filament::dropdown.list class="min-w-44">
                {{-- English --}}
                <x-filament::dropdown.list.item tag="a" :href="route('set-locale', ['locale' => 'en'])" icon="heroicon-m-flag"
                    :color="$current === 'en' ? 'primary' : 'gray'">
                    English

                    <x-slot name="suffix">
                        @if ($current === 'en')
                            <x-filament::icon icon="heroicon-m-check" class="h-4 w-4" />
                        @endif
                    </x-slot>
                </x-filament::dropdown.list.item>

                {{-- العربية --}}
                <x-filament::dropdown.list.item tag="a" :href="route('set-locale', ['locale' => 'ar'])" icon="heroicon-m-flag"
                    :color="$current === 'ar' ? 'primary' : 'gray'">
                    العربية

                    <x-slot name="suffix">
                        @if ($current === 'ar')
                            <x-filament::icon icon="heroicon-m-check" class="h-4 w-4" />
                        @endif
                    </x-slot>
                </x-filament::dropdown.list.item>
            </x-filament::dropdown.list>



        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>
