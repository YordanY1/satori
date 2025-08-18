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

            <form wire:submit.prevent="submit" class="space-y-5" novalidate>
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

                {{-- Submit --}}
                <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                               bg-accent text-black font-semibold shadow-sm
                               hover:bg-accent/90 active:scale-[0.99]
                               focus:outline-none focus:ring-2 focus:ring-accent/60
                               disabled:opacity-60 disabled:cursor-not-allowed transition">
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
                <a href="mailto:info@satori-ko.bg" class="text-accent hover:underline">
                    {{ __('contact.email_link') }}
                </a>
            </p>

            <p class="flex items-center gap-3">
                <span aria-hidden="true">📞</span>
                <a href="tel:+359888123456" class="text-accent hover:underline">
                    {{ __('contact.phone_link') }}
                </a>
            </p>

            <p class="flex items-center gap-3">
                <span aria-hidden="true">📍</span>
                <span>{{ __('contact.address') }}</span>
            </p>

            <div class="pt-2">
                <h3 class="text-sm font-medium text-neutral-600 mb-2">{{ __('contact.socials') }}</h3>
                <div class="flex gap-3 text-2xl">
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="hover:text-accent"
                        aria-label="Facebook">🌐</a>
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="hover:text-accent"
                        aria-label="Instagram">📸</a>
                    <a href="https://youtube.com" target="_blank" rel="noopener" class="hover:text-accent"
                        aria-label="YouTube">▶️</a>
                </div>
            </div>
        </div>
    </div>
</section>
