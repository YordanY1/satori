<div x-data="{ loading: false }">
    <form wire:submit.prevent="login" @submit="loading = true" class="grid gap-3">
        <div>
            <label class="text-sm font-medium">Имейл</label>
            <input type="email" wire:model.lazy="email" autocomplete="email"
                class="w-full mt-1 rounded-xl border px-3 py-2 focus:ring-2 focus:ring-indigo-500 transition" />
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Парола</label>
            <input type="password" wire:model.lazy="password" autocomplete="current-password"
                class="w-full mt-1 rounded-xl border px-3 py-2 focus:ring-2 focus:ring-indigo-500 transition" />
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" wire:model="remember" class="rounded"> Запомни ме
        </label>

        <button type="submit"
            class="relative w-full rounded-xl bg-indigo-600 text-white py-2 font-semibold shadow-lg
                   hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400
                   transition active:scale-95 disabled:opacity-70 cursor-pointer"
            :disabled="loading">
            <span x-show="!loading">🔑 Вход</span>
            <span x-show="loading" class="flex items-center justify-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                Моля, изчакай...
            </span>
        </button>
    </form>
</div>
