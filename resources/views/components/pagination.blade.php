@if ($paginator->hasPages())
    @php
        $pages = collect($paginator->toArray()['links'])->filter(fn($el) => is_numeric($el['label']));
    @endphp

    <nav x-data class="flex items-center justify-center gap-2 mt-8 select-none">

        @foreach ($pages as $el)
            @if ($el['active'])
                <span
                    class="min-w-[36px] h-9 flex items-center justify-center rounded-lg border bg-black text-white font-semibold">
                    {{ $el['label'] }}
                </span>
            @else
                <button wire:click="gotoPage({{ $el['label'] }})"
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="min-w-[36px] h-9 flex items-center justify-center rounded-lg border hover:bg-black hover:text-white transition">
                    {{ $el['label'] }}
                </button>
            @endif
        @endforeach

    </nav>
@endif
