@php
    $program = App\Models\Program::find($getState()[0]->program_id);
    $isCash = $program->is_cash;
@endphp
<div class="grid grid-cols-5 gap-2 p-2">
    <div class="font-bold">{{ __('Trailers') }}</div>
    <div class="font-bold">{{ __('Company') }}</div>
    <div class="font-bold">{{ __('Chalan') }}</div>
    @if ($isCash)
        <div class="font-bold">{{ __('Rent') }}</div>
        <div class="font-bold">{{ __('Commission') }}</div>
    @else
        <div class="font-bold">{{ __('Advance') }}</div>
        <div class="font-bold">{{ __('Due') }}</div>
    @endif
    @foreach ($getState() as $key => $trip)
        <div class="flex gap-4 items-center {{ count($getState()) === $key + 1 ? '' : 'mb-2' }}">
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
        @if ($isCash)
            <div>
                <span class="">৳ {{ $trip->rent }}</span>
            </div>
            <div>
                <span class="">৳ {{ $trip->commission }}</span>
            </div>
        @else
            <div>
                <span class="">৳ {{ $trip->advance }}</span>
            </div>
            <div>
                <span class="">৳ {{ $trip->due }}</span>
            </div>
        @endif
    @endforeach
</div>
