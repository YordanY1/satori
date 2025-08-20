<div>
    <form wire:submit.prevent="register" class="grid gap-3" x-data>
        <div>
            <label for="name" class="text-sm font-medium">{{ __('auth.fields.name') }}</label>
            <input id="name" type="text" wire:model.lazy="name" autocomplete="name"
                placeholder="{{ __('auth.placeholders.name') }}" class="w-full mt-1 rounded-xl border px-3 py-2"
                aria-describedby="name-error" />
            @error('name')
                <p id="name-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="text-sm font-medium">{{ __('auth.fields.email') }}</label>
            <input id="email" type="email" wire:model.lazy="email" autocomplete="email"
                placeholder="{{ __('auth.placeholders.email') }}" class="w-full mt-1 rounded-xl border px-3 py-2"
                aria-describedby="email-error" />
            @error('email')
                <p id="email-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="text-sm font-medium">{{ __('auth.fields.password') }}</label>
            <input id="password" type="password" wire:model.lazy="password" autocomplete="new-password"
                placeholder="{{ __('auth.placeholders.password') }}" class="w-full mt-1 rounded-xl border px-3 py-2"
                aria-describedby="password-error" />
            @error('password')
                <p id="password-error" class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation"
                class="text-sm font-medium">{{ __('auth.fields.password_confirmation') }}</label>
            <input id="password_confirmation" type="password" wire:model.lazy="password_confirmation"
                autocomplete="new-password" placeholder="{{ __('auth.placeholders.password_confirmation') }}"
                class="w-full mt-1 rounded-xl border px-3 py-2" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-black text-white py-2 font-semibold hover:bg-neutral-800">
            {{ __('auth.register_button') }}
        </button>
    </form>
</div>
