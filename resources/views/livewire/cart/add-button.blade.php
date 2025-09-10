<button wire:click="addToCart({{ $bookId }})"
    class="rounded-xl bg-white text-black font-semibold px-4 py-2 shadow-md border border-black
           hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-accent/40
           active:scale-95 transition cursor-pointer">

    {{ __('cart.buy') }}
    <span>
        ({{ number_format($price, 2) }} {{ __('cart.currency') }}
        @if (!empty($price_eur))
             {{ number_format($price_eur, 2) }} €
        @endif
        )
    </span>
</button>
