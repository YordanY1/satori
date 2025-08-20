<div x-data="{ loading: false }">
    <form wire:submit.prevent="login" @submit="loading = true" class="grid gap-3">
        <div>
            <label for="email" class="text-sm font-medium">{{ __('auth.fields.email') }}</label>
            <input id="email" type="email" wire:model.lazy="email" autocomplete="email"
                placeholder="{{ __('auth.placeholders.email') }}"
                class="w-full mt-1 rounded-xl border px-3 py-2 focus:ring-2 focus:ring-indigo-500 transition"
                aria-describedby="email-error" />
            @error('email')
                <p id="email-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="text-sm font-medium">{{ __('auth.fields.password') }}</label>
            <input id="password" type="password" wire:model.lazy="password" autocomplete="current-password"
                placeholder="{{ __('auth.placeholders.password') }}"
                class="w-full mt-1 rounded-xl border px-3 py-2 focus:ring-2 focus:ring-indigo-500 transition"
                aria-describedby="password-error" />
            @error('password')
                <p id="password-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" wire:model="remember" class="rounded" />
            {{ __('auth.remember') }}
        </label>

        <button type="submit"
            class="relative w-full rounded-xl bg-indigo-600 text-white py-2 font-semibold shadow-lg
                   hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400
                   transition active:scale-95 disabled:opacity-70 cursor-pointer"
            :disabled="loading" aria-busy="true">
            <span x-show="!loading">🔑 {{ __('auth.login_button') }}</span>
            <span x-show="loading" class="flex items-center justify-center gap-2" aria-live="polite">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" role="img" aria-label="{{ __('auth.loading_spinner') }}">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                {{ __('auth.please_wait') }}
            </span>
        </button>
    </form>
</div>
