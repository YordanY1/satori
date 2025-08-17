<section class="max-w-3xl mx-auto py-12 px-4 text-center">
    <h1 class="text-3xl font-bold mb-4">Благодарим, {{ $order->name }}!</h1>
    <p class="text-neutral-700 mb-6">
        Поръчката ти №{{ $order->order_number ?? $order->id }} беше приета успешно.
    </p>
    <a href="{{ url('/') }}"
        class="inline-block px-5 py-3 bg-black text-white rounded-xl font-semibold hover:bg-black/90">
        Върни се към началната страница
    </a>
</section>
