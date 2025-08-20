<section class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-extrabold tracking-tight mb-6">{{ __('settings.title') }}</h1>

    <div class="space-y-8">
        <!-- Profile -->
        <div class="rounded-2xl border bg-white shadow-sm">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">{{ __('settings.profile.title') }}</h2>
                <p class="text-sm text-neutral-600 mt-1">{{ __('settings.profile.subtitle') }}</p>
            </div>
            <form wire:submit.prevent="updateProfile" class="p-6 grid gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('settings.fields.name') }}</label>
                    <input type="text" wire:model.lazy="name"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('settings.fields.email') }}</label>
                    <input type="email" wire:model.lazy="email"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('settings.fields.phone') }}</label>
                    <input type="tel" wire:model.lazy="phone" inputmode="tel" pattern="[0-9 +()\-\s]{8,}"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-2.5 text-white font-semibold shadow
                               hover:bg-black/90 active:translate-y-[1px] disabled:opacity-60"
                        wire:loading.attr="disabled" wire:target="updateProfile">
                        <span wire:loading.remove wire:target="updateProfile">{{ __('settings.profile.save') }}</span>
                        <span wire:loading wire:target="updateProfile">{{ __('settings.profile.saving') }}</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Password -->
        <div class="rounded-2xl border bg-white shadow-sm">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">{{ __('settings.password.title') }}</h2>
                <p class="text-sm text-neutral-600 mt-1">{{ __('settings.password.subtitle') }}</p>
            </div>
            <form wire:submit.prevent="updatePassword" class="p-6 grid gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">{{ __('settings.fields.current_password') }}</label>
                    <input type="password" wire:model.lazy="current_password" autocomplete="current-password"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">{{ __('settings.fields.new_password') }}</label>
                        <input type="password" wire:model.lazy="new_password" autocomplete="new-password"
                            class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium mb-1">{{ __('settings.fields.new_password_confirmation') }}</label>
                        <input type="password" wire:model.lazy="new_password_confirmation" autocomplete="new-password"
                            class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-2.5 text-white font-semibold shadow
                               hover:bg-black/90 active:translate-y-[1px] disabled:opacity-60"
                        wire:loading.attr="disabled" wire:target="updatePassword">
                        <span wire:loading.remove
                            wire:target="updatePassword">{{ __('settings.password.change') }}</span>
                        <span wire:loading wire:target="updatePassword">{{ __('settings.password.updating') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
