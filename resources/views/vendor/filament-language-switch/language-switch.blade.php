<x-filament::dropdown placement="bottom-end">
    <style>
        .filament-dropdown-list-item-label {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }
    </style>
    <x-slot name="trigger" class="p-1">
        <div class="filament-dropdown-list-item filament-dropdown-item group flex w-full items-center whitespace-nowrap rounded-md p-2 text-sm outline-none hover:text-white focus:text-white hover:bg-primary-500 focus:bg-primary-500"
            role="button">
            @php
                $locale = config('filament-language-switch.locales')[app()->getLocale()];
            @endphp
            @if (config('filament-language-switch.flag'))
                <span class="fi fi-{{ $locale['flag_code'] }} mr-2 rounded"></span>
            @else
                <x-heroicon-s-globe-alt class="w-6 h-6 text-gray-500 mr-2" />
            @endif

            <div class="filament-dropdown-list-item-label w-full truncate text-start">
                {{ $locale['native'] ?? $locale['name'] }}
                <x-heroicon-o-switch-vertical class="ml-4 w-4 h-4 text-gray-500" />
            </div>
        </div>
    </x-slot>
    <x-filament::dropdown.list class="shadow-lg">
        @foreach (config('filament-language-switch.locales') as $key => $locale)
            @if (!app()->isLocale($key))
                <x-filament::dropdown.list.item wire:click="changeLocale('{{ $key }}')" tag="button">


                    @if (config('filament-language-switch.flag'))
                        <span class="fi fi-{{ $locale['flag_code'] }} mr-2"></span>
                    @else
                        <span
                            class="w-6 h-6 flex items-center justify-center mr-4 flex-shrink-0 rtl:ml-4 @if (!app()->isLocale($key)) group-hover:bg-white group-hover:text-primary-600 group-hover:border group-hover:border-primary-500/10 group-focus:text-white @endif bg-primary-500/10 text-primary-600 font-semibold rounded-full p-1 text-xs">
                            {{ \Illuminate\Support\Str::of($locale['name'])->snake()->upper()->explode('_')->map(function ($string) use ($locale) {
                                    return \Illuminate\Support\Str::of($locale['name'])->wordCount() > 1
                                        ? \Illuminate\Support\Str::substr($string, 0, 1)
                                        : \Illuminate\Support\Str::substr($string, 0, 2);
                                })->take(2)->implode('') }}
                        </span>
                    @endif
                    <span class="hover:bg-transparent">
                        {{ \Illuminate\Support\Str::of($locale[config('filament-language-switch.native') ? 'native' : 'name'])->headline() }}
                    </span>
                </x-filament::dropdown.list.item>
            @endif
        @endforeach

    </x-filament::dropdown.list>
</x-filament::dropdown>
