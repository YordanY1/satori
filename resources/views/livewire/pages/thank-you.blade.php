<section class="max-w-3xl mx-auto py-12 px-4 text-center">
    <h1 class="text-3xl font-bold mb-3">{{ __('thankyou.title') }}</h1>

    <p class="text-neutral-700 mb-6">
        {{ __('thankyou.order_status', ['number' => $order->order_number ?? $order->id]) }}
        <span class="font-semibold">{{ $order->payment_status }}</span>
    </p>

    <a href="{{ url('/') }}"
        class="inline-block px-5 py-3 bg-black text-white rounded-xl font-semibold hover:bg-black/90">
        {{ __('thankyou.home') }}
    </a>
</section>
