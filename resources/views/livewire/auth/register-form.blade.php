<div>
    <form wire:submit.prevent="register" class="grid gap-3" x-data>
        <div>
            <label class="text-sm font-medium">Име</label>
            <input type="text" wire:model.lazy="name" autocomplete="name"
                class="w-full mt-1 rounded-xl border px-3 py-2" />
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Имейл</label>
            <input type="email" wire:model.lazy="email" autocomplete="email"
                class="w-full mt-1 rounded-xl border px-3 py-2" />
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Парола</label>
            <input type="password" wire:model.lazy="password" autocomplete="new-password"
                class="w-full mt-1 rounded-xl border px-3 py-2" />
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Повтори парола</label>
            <input type="password" wire:model.lazy="password_confirmation" autocomplete="new-password"
                class="w-full mt-1 rounded-xl border px-3 py-2" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-black text-white py-2 font-semibold hover:bg-neutral-800">
            Регистрация
        </button>
    </form>
</div>
