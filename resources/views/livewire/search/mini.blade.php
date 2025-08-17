<div class="relative">
    <input type="text" wire:model.debounce.300ms="q" placeholder="Търсене…"
        class="w-44 sm:w-64 rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-neutral-300" />
    @if ($suggestions)
        <div class="absolute z-20 mt-1 w-full bg-white border rounded-xl shadow">
            @foreach ($suggestions as $s)
                <a href="{{ $s['url'] }}" class="block px-3 py-2 text-sm hover:bg-neutral-50">{{ $s['title'] }}</a>
            @endforeach
        </div>
    @endif
</div>
