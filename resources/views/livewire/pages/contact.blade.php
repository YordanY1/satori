<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-8">{{ __('contact.title') }}</h1>

    <div class="grid md:grid-cols-2 gap-8">
        {{-- FORM CARD --}}
        <div class="bg-white border rounded-2xl shadow-sm p-6">
            @if (session('success'))
                <div
                    class="mb-5 flex items-start gap-3 rounded-xl border border-green-300 bg-green-50 px-4 py-3 text-green-800">
                    <span aria-hidden="true">✅</span>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form x-data
                @submit.prevent="
                    const token = grecaptcha.getResponse();
                    $wire.set('recaptcha', token);
                    $wire.call('submit');
                "
                class="space-y-5" novalidate>

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium mb-1">{{ __('contact.name') }}</label>
                    <input type="text" id="name" wire:model="name"
                        placeholder="{{ __('contact.placeholder.name') }}"
                        class="w-full rounded-xl border border-neutral-300 px-3 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-accent/60
                               transition
                               @error('name') border-red-400 ring-2 ring-red-200 @enderror"
                        aria-invalid="@error('name') true @else false @enderror"
                        aria-describedby="@error('name') name-error @enderror">
                    @error('name')
                        <span id="name-error" class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium mb-1">{{ __('contact.email') }}</label>
                    <input type="email" id="email" wire:model="email"
                        placeholder="{{ __('contact.placeholder.email') }}"
                        class="w-full rounded-xl border border-neutral-300 px-3 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-accent/60
                               transition
                               @error('email') border-red-400 ring-2 ring-red-200 @enderror"
                        aria-invalid="@error('email') true @else false @enderror"
                        aria-describedby="@error('email') email-error @enderror">
                    @error('email')
                        <span id="email-error" class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Message --}}
                <div>
                    <label for="message" class="block text-sm font-medium mb-1">{{ __('contact.message') }}</label>
                    <textarea id="message" rows="5" wire:model="message" placeholder="{{ __('contact.placeholder.message') }}"
                        class="w-full rounded-xl border border-neutral-300 px-3 py-2.5
                               focus:outline-none focus:ring-2 focus:ring-accent/60
                               transition resize-y
                               @error('message') border-red-400 ring-2 ring-red-200 @enderror"
                        aria-invalid="@error('message') true @else false @enderror"
                        aria-describedby="@error('message') message-error @enderror"></textarea>
                    @error('message')
                        <span id="message-error" class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="hidden" aria-hidden="true">
                    <label>Website</label>
                    <input type="text" wire:model.defer="website" tabindex="-1" autocomplete="off">
                </div>

                {{-- reCAPTCHA --}}
                <div wire:ignore class="pt-2">
                    <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                    @error('recaptcha')
                        <span class="mt-1 block text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                           bg-accent text-black font-semibold shadow-sm
                           hover:bg-accent/90 active:scale-[0.99]
                           focus:outline-none focus:ring-2 focus:ring-accent/60
                           disabled:opacity-60 disabled:cursor-not-allowed transition cursor-pointer">
                    <span wire:loading.remove>{{ __('contact.send') }}</span>
                    <span wire:loading>{{ __('contact.sending') }}</span>
                    <span aria-hidden="true">📨</span>
                </button>
            </form>
        </div>

        {{-- CONTACT INFO CARD --}}
        <div class="bg-white border rounded-2xl shadow-sm p-6 space-y-5">
            <h2 class="text-xl font-semibold">{{ __('contact.contact_info') }}</h2>

            <p class="flex items-center gap-3">
                <span aria-hidden="true">📧</span>
                <a href="mailto:satorico@abv.bg" class="text-accent hover:underline">
                    {{ __('contact.email_link') }}
                </a>
            </p>

            <p class="flex items-center gap-3">
                <span aria-hidden="true">📞</span>
                <a href="tel:+359878490782" class="text-accent hover:underline">
                    {{ __('contact.phone_link') }}
                </a>
            </p>

            <p class="flex items-center gap-3">
                <span aria-hidden="true">📍</span>
                <span>ж.к. Овча Купел 1, бл. 411, магазин 2, София, България</span>
            </p>

            <div class="pt-2">
                <h3 class="text-sm font-medium text-neutral-600 mb-2">{{ __('contact.socials') }}</h3>
                <div class="flex gap-3 text-2xl">

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/VBelenski" target="_blank" rel="noopener"
                        class="hover:text-accent" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path
                                d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0 0 22 12z" />
                        </svg>
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>
