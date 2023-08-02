<div class="p-1">
    @foreach ($getState() as $key => $trailer)
        <div class="mb-1">{{ $trailer->number }}</div>
    @endforeach
</div>
