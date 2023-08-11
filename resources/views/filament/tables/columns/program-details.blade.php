@php
    $program = App\Models\Program::find($getState());
    $number = new NumberFormatter('en_IN', NumberFormatter::DEFAULT_STYLE);
    $weight = $number->format($program->weight);
    $fare = $number->format($program->fare);
@endphp
<div class="">
    <p class="font-bold">
        {{ $program->party->name }},<br> {{ $program->factory->name }}
    </p>

    <div class="flex gap-4">

        <p class=""> <span>{{ trans('Weight') }}:</span> {{ $weight }} Kg</p>
        @if ($program->is_cash)
            <span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-sm">
                {{ __('Cash') }}
            </span>
        @else
            <span class="bg-rose-100 text-rose-700 py-1 px-2 rounded-full text-sm">
                {{ __('Due') }}
            </span>
        @endif
    </div>
    @if ($program->is_cash)
        <p> <span>{{ trans('Job') . ' ' . trans('No.') }}</span> {{ $program->job_no }}</p>
    @endif


</div>
