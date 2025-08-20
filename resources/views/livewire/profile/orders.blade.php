<section class="max-w-4xl mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">{{ __('orders.title') }}</h1>

    @forelse($orders as $order)
        <div class="rounded-xl border p-4 mb-4">
            <div class="flex justify-between items-center">
                <p class="font-semibold">{{ __('orders.order_number', ['id' => $order->id]) }}</p>
                <span class="text-sm text-neutral-600">
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </span>
            </div>

            <p class="mt-2 text-sm text-neutral-700">
                {{ trans_choice('orders.items_count', $order->items->count(), ['count' => $order->items->count()]) }}
                @if ($order->paid_at)
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700">
                        {{ __('orders.status.paid') }}
                    </span>
                @else
                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-yellow-100 text-yellow-700">
                        {{ __('orders.status.unpaid') }}
                    </span>
                @endif
            </p>
        </div>
    @empty
        <p class="text-neutral-600">{{ __('orders.empty') }}</p>
    @endforelse
</section>
