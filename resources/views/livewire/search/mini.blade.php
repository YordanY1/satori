<div class="relative" x-data @lw-debug.window="console.log('LW Debug:', $event.detail)">
    <input type="text" wire:model.live.debounce.300ms="q" placeholder="{{ __('search.placeholder') }}"
        class="w-full max-w-md rounded-xl border px-3 py-2 text-sm
       focus:outline-none focus:ring-2 focus:ring-neutral-300" />

    @if ($q !== '' && mb_strlen($q) >= 2 && empty($suggestions))
        <div
            class="absolute left-0 z-50 mt-1 w-full bg-white border rounded-xl shadow px-3 py-2 text-sm text-neutral-500">
            {{ __('search.no_results', ['q' => $q]) }}
        </div>
    @endif

    @if (!empty($suggestions))
        <div class="absolute left-0 z-50 mt-1 w-full bg-white border rounded-xl shadow divide-y">
            @foreach ($suggestions as $s)
                <a href="{{ $s['url'] }}" class="flex items-center gap-3 px-3 py-2 text-sm hover:bg-neutral-50"
                    wire:key="sug-{{ $loop->index }}">
                    @if (!empty($s['cover']))
                        <img src="{{ $s['cover'] }}" alt="{{ $s['title'] }}" class="w-8 h-12 object-cover rounded">
                    @endif
                    <span>{{ $s['title'] }}</span>
                </a>
            @endforeach
        </div>
    @endif
</div>
