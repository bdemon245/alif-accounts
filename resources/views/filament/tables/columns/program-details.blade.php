@php
    $program = App\Models\Program::find($getState());
    $number = new NumberFormatter('en_IN', NumberFormatter::DEFAULT_STYLE);
    $weight = $number->format($program->weight);
    $fare = $number->format($program->fare);
@endphp
<div class="">
    <p class="font-bold">
        {{ $program->party->name }}, {{ $program->factory->name }}
    </p>

    <div class="flex gap-8">
        <p class="text-green-600">
            <span class="font-bold">{{ trans('Fare') }}:</span> {{ $fare }} <span
                class="font-bold">&#x09F3;</span>
        </p>
        <p class=""> <span>{{ trans('Weight') }}:</span> {{ $weight }} Kg</p>
    </div>
    @if ($program->is_cash)
        <p> <span>{{ trans('Job') . ' ' . trans('No.') }}</span> {{ $program->job_no }}</p>
    @endif


</div>
