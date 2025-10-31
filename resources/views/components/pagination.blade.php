@if ($paginator->hasPages())
    @php
        $pages = collect($paginator->toArray()['links'])
            ->filter(fn($el) => is_numeric($el['label']));
    @endphp

    <nav x-data class="flex items-center justify-center gap-2 mt-10">
        @foreach ($pages as $el)
            @if ($el['active'])
                <span class="min-w-[42px] h-11 flex items-center justify-center rounded-xl border border-black bg-black text-white font-semibold text-base">
                    {{ $el['label'] }}
                </span>
            @else
                <button
                    wire:click="gotoPage({{ $el['label'] }})"
                    @click="window.scrollTo({ top: document.querySelector('#catalog-title').offsetTop - 20, behavior: 'smooth' })"
                    class="min-w-[42px] h-11 flex items-center justify-center rounded-xl border border-gray-400 hover:bg-black hover:text-white text-base transition"
                >
                    {{ $el['label'] }}
                </button>
            @endif
        @endforeach
    </nav>
@endif
