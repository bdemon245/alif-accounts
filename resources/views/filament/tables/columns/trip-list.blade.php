<div class="grid grid-cols-5 gap-2 px-2">
    <div class="font-bold">{{ __('Trailers') }}</div>
    <div class="font-bold">{{ __('Company') }}</div>
    <div class="font-bold">{{ __('Chalan') }}</div>
    <div class="font-bold">{{ __('Advance') }}</div>
    <div class="font-bold">{{ __('Due') }}</div>
    @foreach ($getState() as $key => $trip)
        <div class="flex gap-4 items-center {{ count($getState()) === $key + 1 ? '' : 'mb-4' }}">
            <div class="border-green-200 border-r-4 px-1">
                @foreach ($trip->trailer_no as $trailer)
                    <div class="mb-1">{{ $trailer }}</div>
                @endforeach
            </div>
        </div>
        <div>
            <span class="font-bold text-green-600">{{ $trip->company->name }}</span>
        </div>
        <div>
            <span class="">৳ {{ $trip->chalan }}</span>
        </div>
        <div>
            <span class="">৳ {{ $trip->advance }}</span>
        </div>
        <div>
            <span class="">৳ {{ $trip->due }}</span>
        </div>
    @endforeach
</div>
