<section class="max-w-4xl mx-auto py-10 px-4">
    <div class="bg-white/90 backdrop-blur rounded-2xl shadow-xl border border-black/5">
        <div class="px-6 sm:px-8 py-6 border-b border-black/5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Финализирай поръчката</h1>
            <p class="mt-1 text-sm text-neutral-600">Попълни данните си и завърши поръчката в два клика.</p>
        </div>

        <form wire:submit.prevent="placeOrder" class="grid grid-cols-1 gap-6 p-6 sm:p-8" x-data>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-1">Име</label>
                    <input type="text" wire:model.lazy="name" autocomplete="name"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                  focus:outline-none focus:ring-4 focus:ring-black/10 @error('name') border-red-500 @enderror"
                        aria-invalid="@error('name') true @else false @enderror">
                    @error('name')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Имейл</label>
                    <input type="email" wire:model.lazy="email" autocomplete="email"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                  focus:outline-none focus:ring-4 focus:ring-black/10 @error('email') border-red-500 @enderror"
                        aria-invalid="@error('email') true @else false @enderror">
                    @error('email')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Телефон</label>
                    <input type="tel" wire:model.lazy="phone" autocomplete="tel" inputmode="tel"
                        pattern="[0-9 +()\-\s]{8,}"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
         focus:outline-none focus:ring-4 focus:ring-black/10 @error('phone') border-red-500 @enderror"
                        aria-invalid="@error('phone') true @else false @enderror" />

                    @error('phone')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Адрес</label>
                    <textarea wire:model.lazy="address" autocomplete="street-address" rows="3"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                     focus:outline-none focus:ring-4 focus:ring-black/10 @error('address') border-red-500 @enderror"
                        aria-invalid="@error('address') true @else false @enderror"></textarea>
                    @error('address')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1">Метод на плащане</label>
                    <select wire:model="payment_method"
                        class="w-full rounded-xl border border-neutral-300 bg-white px-3 py-2 text-[15px] shadow-sm
                                   focus:outline-none focus:ring-4 focus:ring-black/10 @error('payment_method') border-red-500 @enderror"
                        aria-invalid="@error('payment_method') true @else false @enderror">
                        <option value="cod">Плащане при доставка</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Карта (Stripe)</option>
                    </select>
                    @error('payment_method')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-2 rounded-2xl border border-black/5 bg-neutral-50 p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-[15px] font-medium text-neutral-700">Общо</h2>
                    <div class="text-xl font-bold tracking-tight">{{ number_format($total, 2) }} лв.</div>
                </div>

                @error('cart')
                    <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                @enderror

                <div class="mt-4 flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-3 text-white font-semibold shadow-lg shadow-black/5
                                   hover:bg-black/90 active:translate-y-[1px] disabled:opacity-60 disabled:cursor-not-allowed
                                   focus:outline-none focus:ring-4 focus:ring-black/20"
                        wire:loading.attr="disabled" x-bind:disabled="$wire.get('total') <= 0">
                        <span wire:loading.remove>Потвърди поръчката</span>
                        <span wire:loading>Обработваме…</span>
                    </button>

                    <a href="{{ route('cart') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-neutral-300 bg-white px-5 py-3 font-medium text-neutral-800
                              hover:bg-neutral-100 focus:outline-none focus:ring-4 focus:ring-black/10">
                        Върни се към количката
                    </a>
                </div>
            </div>
        </form>
    </div>
</section>
