<section class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-black/5">
        <div class="px-6 sm:px-8 py-6 border-b border-black/5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">{{ __('checkout.title') }}</h1>
            <p class="mt-1 text-sm text-neutral-600">{{ __('checkout.subtitle') }}</p>
        </div>

        <form wire:submit.prevent="placeOrder" class="grid grid-cols-1 gap-6 p-6 sm:p-8" x-data>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('checkout.name') }}</label>
                    <input type="text" wire:model.lazy="name" autocomplete="name"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                               focus:outline-none focus:ring-4 focus:ring-black/10 @error('name') border-red-500 @enderror"
                        aria-invalid="@error('name') true @else false @enderror">
                    @error('name')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('checkout.email') }}</label>
                    <input type="email" wire:model.lazy="email" autocomplete="email"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                               focus:outline-none focus:ring-4 focus:ring-black/10 @error('email') border-red-500 @enderror"
                        aria-invalid="@error('email') true @else false @enderror">
                    @error('email')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('checkout.phone') }}</label>
                    <input type="tel" wire:model.lazy="phone" autocomplete="tel" inputmode="tel"
                        pattern="[0-9 +()\-\s]{8,}"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                               focus:outline-none focus:ring-4 focus:ring-black/10 @error('phone') border-red-500 @enderror"
                        aria-invalid="@error('phone') true @else false @enderror" />
                    @error('phone')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="sm:col-span-2 rounded-2xl border border-black/5 bg-neutral-50 p-5">
                    <h2 class="text-[15px] font-semibold mb-3">Адрес за доставка</h2>

                    <div class="flex flex-col sm:flex-row gap-3 mb-4">
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" class="accent-black" wire:model.live="shipping_method"
                                value="econt_office">
                            <span>До офис на Еконт</span>
                        </label>
                        <label class="inline-flex items-center gap-2">
                            <input type="radio" class="accent-black" wire:model.live="shipping_method"
                                value="address">
                            <span>До адрес</span>
                        </label>
                    </div>

                    @if ($shipping_method === 'address')
                        <div wire:key="shipping-address-block" x-data
                            x-on:focus-city-input.window="$nextTick(() => $refs.cityInput?.focus())">
                            <label class="block text-sm font-medium mb-1">Град</label>
                            <input x-ref="cityInput" type="text" wire:model.live.debounce.250ms="citySearch"
                                placeholder="Започни да пишеш: София, Пловдив..."
                                class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                       focus:outline-none focus:ring-4 focus:ring-black/10 @error('cityId') border-red-500 @enderror"
                                autocomplete="off">
                            @error('cityId')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror

                            @if (!empty($cityOptions))
                                <ul class="relative z-50 mt-1 w-full max-h-72 overflow-auto rounded-xl border bg-white shadow-lg"
                                    x-on:click.outside="$wire.set('cityOptions', [])">
                                    @foreach ($cityOptions as $opt)
                                        <li class="px-3 py-2 hover:bg-neutral-100 cursor-pointer"
                                            wire:key="city-{{ $opt['id'] }}" x-on:mousedown.prevent.stop
                                            wire:click.prevent="selectCity(@js($opt['id']), @js($opt['label']), @js($opt['post_code'] ?? null))">
                                            {{ $opt['label'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($cityId)
                                <p class="mt-2 text-sm text-neutral-700">
                                    Избран град: <span class="font-medium">{{ $cityLabel }}</span>
                                    @if ($cityPostCode)
                                        <span class="text-neutral-500"> (П.к. {{ $cityPostCode }})</span>
                                    @endif
                                    <button type="button" class="underline ml-2"
                                        wire:click="$set('cityId', null); $set('cityLabel',''); $set('citySearch',''); $set('cityPostCode', null);">
                                        Смени
                                    </button>
                                </p>
                            @endif
                        </div>

                        <div class="mt-3" x-data>
                            <label class="block text-sm font-medium mb-1">Улица</label>
                            <input type="text" wire:model.live.debounce.250ms="streetSearch"
                                placeholder="Започни да пишеш: бул. Цар Борис..."
                                class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                       focus:outline-none focus:ring-4 focus:ring-black/10 @error('streetCode') border-red-500 @enderror"
                                autocomplete="off">
                            @error('streetCode')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror

                            @if (!empty($streetOptions))
                                <ul class="relative z-50 mt-1 w-full max-h-72 overflow-auto rounded-xl border bg-white shadow-lg"
                                    x-on:click.outside="$wire.set('streetOptions', [])">
                                    @foreach ($streetOptions as $opt)
                                        <li class="px-3 py-2 hover:bg-neutral-100 cursor-pointer"
                                            wire:key="street-{{ $opt['id'] }}" x-on:mousedown.prevent.stop
                                            wire:click.prevent="selectStreet(@js($opt['id']), @js($opt['value']), @js($opt['label']))">
                                            {{ $opt['label'] }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            @if ($streetCode)
                                <p class="mt-2 text-sm text-neutral-700">
                                    Избрана улица: <span class="font-medium">{{ $streetLabel }}</span>
                                    <button type="button" class="underline ml-2"
                                        wire:click="$set('streetId', null); $set('streetCode', null); $set('streetLabel',''); $set('streetSearch','');">
                                        Смени
                                    </button>
                                </p>
                            @endif
                        </div>

                        <div class="mt-3">
                            <label class="block text-sm font-medium mb-1">Номер</label>
                            <input type="text" wire:model.lazy="streetNum" placeholder="№ (пример: 12, 12А, 12/1)"
                                class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                       focus:outline-none focus:ring-4 focus:ring-black/10">
                        </div>
                    @endif

                    @if ($shipping_method === 'econt_office')
                        <div class="relative" wire:key="shipping-econt-office-only" x-data
                            x-on:focus-office-input.window="$nextTick(() => $refs.officeInput?.focus())">
                            <label class="block text-sm font-medium mb-1">Офис на Еконт</label>
                            <input x-ref="officeInput" type="text" wire:model.live.debounce.300ms="officeSearch"
                                wire:keydown.escape="$set('officeOptions', [])"
                                placeholder="Започни да пишеш: София, Пловдив, бул. България..."
                                class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                       focus:outline-none focus:ring-4 focus:ring-black/10 @error('officeCode') border-red-500 @enderror">
                            @error('officeCode')
                                <span class="text-red-600 text-xs">{{ $message }}</span>
                            @enderror

                            @if (!empty($officeOptions))
                                <ul class="absolute z-50 mt-1 w-full max-h-72 overflow-auto rounded-xl border bg-white shadow-lg"
                                    x-on:click.outside="$wire.set('officeOptions', [])">
                                    @forelse ($officeOptions as $opt)
                                        <li class="px-3 py-2 hover:bg-neutral-100 cursor-pointer"
                                            wire:key="office-{{ $opt['value'] }}" x-on:mousedown.prevent.stop
                                            wire:click.prevent="selectOffice(@js($opt['value']), @js($opt['label']))">
                                            {{ $opt['label'] }}
                                        </li>
                                    @empty
                                        <li class="px-3 py-2 text-sm text-neutral-500">Няма резултати</li>
                                    @endforelse
                                </ul>
                            @endif

                            @if ($officeCode)
                                <p class="mt-2 text-sm text-neutral-700">
                                    Избран офис: <span class="font-medium">{{ $officeLabel }}</span>
                                    <button type="button" class="underline ml-2"
                                        wire:click="$set('officeCode', null); $set('officeLabel',''); $set('officeSearch','');">
                                        Смени
                                    </button>
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">{{ __('checkout.payment_method') }}</label>
                    <select wire:model="payment_method"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                               focus:outline-none focus:ring-4 focus:ring-black/10 @error('payment_method') border-red-500 @enderror"
                        aria-invalid="@error('payment_method') true @else false @enderror">
                        <option value="cod">{{ __('checkout.payment.cod') }}</option>
                        <option value="paypal">{{ __('checkout.payment.paypal') }}</option>
                        <option value="stripe">{{ __('checkout.payment.stripe') }}</option>
                    </select>
                    @error('payment_method')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-2 rounded-2xl border border-black/5 bg-neutral-50 p-5">
                <div class="mt-2 rounded-2xl border border-black/5 bg-neutral-50 p-5 space-y-2">
                    {{-- Subtotal --}}
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-600">Стойност продукти</span>
                        <span class="font-medium">{{ number_format($subtotal, 2) }}
                            {{ __('checkout.currency') }}</span>
                    </div>

                    {{-- Shipping --}}
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-neutral-600">Доставка</span>
                        <span class="font-medium">
                            @if ($shippingCost > 0)
                                {{ number_format($shippingCost, 2) }} {{ __('checkout.currency') }}
                            @else
                                —
                            @endif
                        </span>
                    </div>

                    <hr class="my-2">

                    {{-- Total --}}
                    <div class="flex items-center justify-between">
                        <h2 class="text-[15px] font-semibold text-neutral-700">{{ __('checkout.total') }}</h2>
                        <div class="text-xl font-bold tracking-tight">
                            {{ number_format($total, 2) }} {{ __('checkout.currency') }}
                        </div>
                    </div>
                </div>

                @error('cart')
                    <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <div class="mt-4 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-3 text-white font-semibold shadow-lg shadow-black/5
                               hover:bg-black/90 active:translate-y-[1px] disabled:opacity-60 disabled:cursor-not-allowed
                               focus:outline-none focus:ring-4 focus:ring-black/20"
                        wire:loading.attr="disabled" wire:target="placeOrder"
                        x-bind:disabled="$wire.get('total') <= 0">
                        <span wire:loading.remove wire:target="placeOrder">{{ __('checkout.confirm') }}</span>
                        <span wire:loading wire:target="placeOrder">{{ __('checkout.processing') }}</span>
                    </button>
                    <a href="{{ route('cart') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-neutral-300 bg-white px-5 py-3 font-medium text-neutral-800
                               hover:bg-neutral-100 focus:outline-none focus:ring-4 focus:ring-black/10">
                        {{ __('checkout.back_to_cart') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>
