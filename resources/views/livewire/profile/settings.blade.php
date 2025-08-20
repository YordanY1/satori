<section class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-extrabold tracking-tight mb-6">Настройки</h1>

    <div class="space-y-8">

        <div class="rounded-2xl border bg-white shadow-sm">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Профил</h2>
                <p class="text-sm text-neutral-600 mt-1">Редактирай име, имейл и телефон.</p>
            </div>
            <form wire:submit.prevent="updateProfile" class="p-6 grid gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Име</label>
                    <input type="text" wire:model.lazy="name"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Имейл</label>
                    <input type="email" wire:model.lazy="email"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Телефон</label>
                    <input type="tel" wire:model.lazy="phone" inputmode="tel" pattern="[0-9 +()\-\s]{8,}"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10">
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-2.5 text-white font-semibold shadow
                                   hover:bg-black/90 active:translate-y-[1px] disabled:opacity-60"
                        wire:loading.attr="disabled" wire:target="updateProfile">
                        <span wire:loading.remove wire:target="updateProfile">Запази</span>
                        <span wire:loading wire:target="updateProfile">Записване…</span>
                    </button>
                </div>
            </form>
        </div>


        <div class="rounded-2xl border bg-white shadow-sm">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Смяна на парола</h2>
                <p class="text-sm text-neutral-600 mt-1">За сигурност е нужно да потвърдиш текущата парола.</p>
            </div>
            <form wire:submit.prevent="updatePassword" class="p-6 grid gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Текуща парола</label>
                    <input type="password" wire:model.lazy="current_password" autocomplete="current-password"
                        class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Нова парола</label>
                        <input type="password" wire:model.lazy="new_password" autocomplete="new-password"
                            class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10 @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Повтори новата парола</label>
                        <input type="password" wire:model.lazy="new_password_confirmation" autocomplete="new-password"
                            class="w-full rounded-xl border px-3 py-2 focus:outline-none focus:ring-4 focus:ring-black/10">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-black px-5 py-2.5 text-white font-semibold shadow
                                   hover:bg-black/90 active:translate-y-[1px] disabled:opacity-60"
                        wire:loading.attr="disabled" wire:target="updatePassword">
                        <span wire:loading.remove wire:target="updatePassword">Смени паролата</span>
                        <span wire:loading wire:target="updatePassword">Обновяване…</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
