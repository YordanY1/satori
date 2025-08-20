<div class="absolute top-2 right-2">
    <button wire:click="toggle" wire:loading.attr="disabled"
        class="p-2 rounded-full shadow bg-white/80 backdrop-blur
               hover:bg-red-100 transition
               @if ($isFav) text-red-500 @else text-gray-400 hover:text-red-500 @endif"
        aria-label="Добави в любими">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
            <path
                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
        </svg>
    </button>

    @if ($count > 0)
        <span class="absolute -bottom-1 -right-1 text-[10px] font-semibold bg-red-500 text-white rounded-full px-1">
            {{ $count }}
        </span>
    @endif
</div>
