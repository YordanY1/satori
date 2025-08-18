<button wire:click="addToCart({{ $bookId }})"
    class="rounded-xl bg-white text-black font-semibold px-4 py-2 shadow-md border border-black
           hover:bg-neutral-100 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-accent/40
           active:scale-95 transition cursor-pointer">

    {{ __('cart.buy') }}
    <span>({{ __('cart.price', ['amount' => number_format($price, 2), 'currency' => __('cart.currency')]) }})</span>
</button>
