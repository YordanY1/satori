<section class="max-w-md mx-auto bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold mb-4">{{ __('auth.login_title') }}</h1>

    @livewire('auth.login-form')

    <div class="mt-4 text-sm text-neutral-600 flex justify-between items-center">
        <a href="{{ route('password.request') }}" class="text-sky-600 hover:underline">
            {{ __('auth.forgot_password') }}
        </a>
    </div>
</section>
