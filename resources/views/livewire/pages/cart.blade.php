<section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10" aria-labelledby="cart-title">
    <h1 id="cart-title" class="text-3xl font-extrabold tracking-tight mb-8">
        {{ __('cart.title') }}
    </h1>

    @if (count($cart) === 0)
        <div class="bg-gray-50 rounded-2xl p-10 text-center">
            <p class="text-neutral-600 text-lg">{{ __('cart.empty') }}</p>
        </div>
    @else
        {{-- MOBILE --}}
        <div class="space-y-4 md:hidden">
            @foreach ($cart as $id => $item)
                @php
                    $img = \Illuminate\Support\Str::startsWith($item['cover'], ['http://', 'https://'])
                        ? $item['cover']
                        : asset($item['cover']);
                @endphp
                <article class="rounded-2xl border bg-white p-4 shadow-sm">
                    <div class="flex gap-3">
                        <img src="{{ $img }}" alt="{{ $item['title'] }}"
                            class="h-24 w-20 object-cover rounded-lg border">
                        <div class="flex-1">
                            <a wire:navigate href="{{ route('book.show', $item['slug']) }}"
                                class="font-semibold text-text leading-snug line-clamp-2">
                                {{ $item['title'] }}
                            </a>

                            <div class="mt-2 text-sm text-neutral-600">
                                {{ __('cart.price') }}:
                                <span class="font-medium text-text">
                                    {{ number_format($item['price'], 2) }} {{ __('cart.currency') }}
                                </span>
                                @if (!empty($item['price_eur']))
                                    <br>
                                    <span class="text-xs text-gray-500">
                                         {{ number_format($item['price_eur'], 2) }} €
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="inline-flex items-center gap-2 border rounded-lg px-2 py-1">
                                    <button wire:click="decrement({{ $id }})"
                                        class="px-3 py-1 rounded-lg bg-gray-100 active:translate-y-[1px]">−</button>
                                    <span class="min-w-[2ch] text-center font-medium">{{ $item['quantity'] }}</span>
                                    <button wire:click="increment({{ $id }})"
                                        class="px-3 py-1 rounded-lg bg-gray-100 active:translate-y-[1px]">+</button>
                                </div>

                                <div class="font-semibold text-right">
                                    {{ number_format($item['price'] * $item['quantity'], 2) }}
                                    {{ __('cart.currency') }}
                                    @if (!empty($item['price_eur']))
                                        <br>
                                        <span class="text-xs text-gray-500">
                                             {{ number_format($item['price_eur'] * $item['quantity'], 2) }} €
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 text-right">
                                <button wire:click="remove({{ $id }})"
                                    class="px-3 py-1 rounded-lg border border-red-300 text-red-600 active:translate-y-[1px]">
                                    {{ __('cart.remove') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- DESKTOP/TABLET --}}
        <div class="overflow-hidden rounded-2xl border shadow-sm bg-white hidden md:block">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr class="text-left text-gray-600">
                        <th class="p-4">{{ __('cart.title') }}</th>
                        <th class="p-4">{{ __('cart.price') }}</th>
                        <th class="p-4">{{ __('cart.quantity') }}</th>
                        <th class="p-4">{{ __('cart.total') }}</th>
                        <th class="p-4"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        @php
                            $img = \Illuminate\Support\Str::startsWith($item['cover'], ['http://', 'https://'])
                                ? $item['cover']
                                : asset($item['cover']);
                        @endphp
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $img }}" alt="{{ $item['title'] }}"
                                        class="h-24 w-20 object-cover rounded-lg border">
                                    <a wire:navigate href="{{ route('book.show', $item['slug']) }}"
                                        class="font-semibold text-gray-800 hover:underline block line-clamp-2">
                                        {{ $item['title'] }}
                                    </a>
                                </div>
                            </td>
                            <td class="p-4 font-medium whitespace-nowrap">
                                {{ number_format($item['price'], 2) }} {{ __('cart.currency') }}
                                @if (!empty($item['price_eur']))
                                    <br>
                                    <span class="text-xs text-gray-500">
                                         {{ number_format($item['price_eur'], 2) }} €
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="inline-flex items-center gap-2 border rounded-lg px-2 py-1">
                                    <button wire:click="decrement({{ $id }})"
                                        class="px-3 py-1 rounded-lg bg-gray-100 active:translate-y-[1px]">−</button>
                                    <span class="min-w-[2ch] text-center font-medium">{{ $item['quantity'] }}</span>
                                    <button wire:click="increment({{ $id }})"
                                        class="px-3 py-1 rounded-lg bg-gray-100 active:translate-y-[1px]">+</button>
                                </div>
                            </td>
                            <td class="p-4 font-semibold text-accent whitespace-nowrap">
                                {{ number_format($item['price'] * $item['quantity'], 2) }} {{ __('cart.currency') }}
                                @if (!empty($item['price_eur']))
                                    <br>
                                    <span class="text-xs text-gray-500">
                                         {{ number_format($item['price_eur'] * $item['quantity'], 2) }} €
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <button wire:click="remove({{ $id }})"
                                    class="px-3 py-1 rounded-lg border border-red-300 text-red-600 hover:bg-red-50 active:translate-y-[1px]">
                                    ✕
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals / actions --}}
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <button wire:click="clear"
                class="px-5 py-2.5 rounded-xl border border-gray-400 text-gray-700 hover:bg-gray-100 active:translate-y-[1px]">
                {{ __('cart.clear') }}
            </button>

            <div class="flex flex-col sm:flex-row items-center gap-6 text-center sm:text-right">
                <div class="text-lg sm:text-xl">
                    <span class="text-neutral-600">{{ __('cart.subtotal') }}</span>
                    <span class="font-extrabold">{{ number_format($total, 2) }} {{ __('cart.currency') }}</span>
                    @if (!empty(\App\Support\Cart::totalEur()))
                        <br>
                        <span class="text-sm text-gray-500 font-medium">
                             {{ number_format(\App\Support\Cart::totalEur(), 2) }} €
                        </span>
                    @endif
                </div>
                <a wire:navigate href="{{ route('checkout') }}"
                    class="px-6 py-3 rounded-xl border border-accent text-text font-semibold shadow active:translate-y-[1px]">
                    {{ __('cart.checkout') }}
                </a>
            </div>
        </div>
    @endif
</section>
