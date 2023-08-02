<div class="p-1">
    @foreach ($getState() as $key => $trip)
        <div class="flex gap-4 items-center {{ count($getState()) === $key + 1 ? '' : 'mb-4' }}">
            <div class="border-green-200 border-r-4 px-1">
                @foreach ($trip->trailer_no as $trailer)
                    <div class="mb-1">{{ $trailer }}</div>
                @endforeach
            </div>
            <div>
                <span class="font-bold text-green-600">{{ $trip->company->name }}</span>
            </div>
        </div>
    @endforeach
</div>
