<section class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">{{ __('Reset Password') }}</h1>

    @if (session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="resetPassword">
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">{{ __('Email') }}</label>
            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
            @error('email')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">{{ __('New Password') }}</label>
            <input type="password" wire:model="password" class="w-full border rounded px-3 py-2">
            @error('password')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">{{ __('Confirm Password') }}</label>
            <input type="password" wire:model="password_confirmation" class="w-full border rounded px-3 py-2">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            {{ __('Reset Password') }}
        </button>
    </form>
</section>
