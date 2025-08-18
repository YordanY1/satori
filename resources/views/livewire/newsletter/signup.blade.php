<form wire:submit.prevent="subscribe" class="flex flex-col sm:flex-row gap-2"
    aria-label="{{ __('newsletter.form_aria') }}">

    <label for="newsletter-email" class="sr-only">
        {{ __('newsletter.email_label') }}
    </label>

    <input type="email" id="newsletter-email" wire:model="email" placeholder="{{ __('newsletter.email_placeholder') }}"
        required
        class="w-full rounded-lg border border-neutral-300 px-3 py-1.5
                  focus:outline-none focus:ring-2 focus:ring-accent
                  placeholder:text-neutral-400 text-text text-sm">

    <button type="submit"
        class="rounded-lg border border-accent text-text px-3 py-1.5 text-sm font-medium
                   active:scale-95 transition-transform focus:outline-none focus:ring-2 focus:ring-accent cursor-pointer">
        {{ __('newsletter.submit') }}
    </button>
</form>

@error('email')
    <div class="text-sm text-red-600 mt-2" role="alert">{{ $message }}</div>
@enderror

@if ($ok)
    <div class="text-sm text-green-700 mt-2" role="status">
        {{ __('newsletter.success') }}
    </div>
@endif
