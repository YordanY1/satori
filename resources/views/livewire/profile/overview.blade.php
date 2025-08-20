<section class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">{{ __('profile.title') }}</h1>
            <p class="text-sm text-neutral-600 mt-1">{{ __('profile.subtitle') }}</p>
        </div>
        <a wire:navigate href="{{ route('profile.settings') }}"
            class="inline-flex items-center gap-2 rounded-xl border px-4 py-2 text-sm font-semibold
                  hover:bg-neutral-50 active:scale-95 transition focus:outline-none focus:ring-2 focus:ring-black/10">
            ⚙️ {{ __('profile.settings') }}
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 rounded-2xl border bg-white shadow-sm">
            <div class="p-6 flex items-start gap-4">
                @php
                    $initials = collect(explode(' ', $user->name))
                        ->map(fn($p) => mb_substr($p, 0, 1))
                        ->take(2)
                        ->implode('');
                @endphp
                <div
                    class="size-14 rounded-2xl bg-gradient-to-tr from-black to-neutral-700 text-white
                            flex items-center justify-center text-lg font-bold shadow">
                    {{ $initials }}
                </div>

                <div class="flex-1">
                    <h2 class="text-lg font-semibold">{{ __('profile.data.title') }}</h2>
                    <dl class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-xl border bg-neutral-50 px-4 py-3">
                            <dt class="text-xs uppercase tracking-wide text-neutral-500">{{ __('profile.data.name') }}
                            </dt>
                            <dd class="mt-1 font-medium">{{ $user->name }}</dd>
                        </div>
                        <div class="rounded-xl border bg-neutral-50 px-4 py-3">
                            <dt class="text-xs uppercase tracking-wide text-neutral-500">{{ __('profile.data.email') }}
                            </dt>
                            <dd class="mt-1 font-medium">{{ $user->email }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="rounded-2xl border bg-white shadow-sm p-3">
            <h3 class="px-3 pt-2 pb-3 text-sm font-semibold text-neutral-700">{{ __('profile.navigation.title') }}</h3>

            <div class="grid gap-3">
                <a wire:navigate href="{{ route('profile.orders') }}"
                    class="group rounded-xl border px-4 py-3 hover:bg-neutral-50 transition
                          focus:outline-none focus:ring-2 focus:ring-black/10 active:scale-[.99]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">🧾</span>
                            <div>
                                <p class="font-semibold">{{ __('profile.navigation.orders.title') }}</p>
                                <p class="text-xs text-neutral-600">{{ __('profile.navigation.orders.subtitle') }}</p>
                            </div>
                        </div>
                        <span class="opacity-0 group-hover:opacity-100 transition">→</span>
                    </div>
                </a>

                <a wire:navigate href="{{ route('profile.favorites') }}"
                    class="group rounded-xl border px-4 py-3 hover:bg-neutral-50 transition
                          focus:outline-none focus:ring-2 focus:ring-black/10 active:scale-[.99]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">⭐</span>
                            <div>
                                <p class="font-semibold">{{ __('profile.navigation.favorites.title') }}</p>
                                <p class="text-xs text-neutral-600">{{ __('profile.navigation.favorites.subtitle') }}
                                </p>
                            </div>
                        </div>
                        <span class="opacity-0 group-hover:opacity-100 transition">→</span>
                    </div>
                </a>

                <a wire:navigate href="{{ route('profile.settings') }}"
                    class="group rounded-xl border px-4 py-3 hover:bg-neutral-50 transition
                          focus:outline-none focus:ring-2 focus:ring-black/10 active:scale-[.99]">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">⚙️</span>
                            <div>
                                <p class="font-semibold">{{ __('profile.navigation.settings.title') }}</p>
                                <p class="text-xs text-neutral-600">{{ __('profile.navigation.settings.subtitle') }}
                                </p>
                            </div>
                        </div>
                        <span class="opacity-0 group-hover:opacity-100 transition">→</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
