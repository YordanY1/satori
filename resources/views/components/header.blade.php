<header class="border-b bg-white shadow-sm" role="banner" x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

        <!-- Logo -->
        <a wire:navigate href="{{ url('/') }}" class="flex items-center gap-3 group"
            aria-label="{{ __('navigation.home_aria') }}">
            <img src="{{ asset('logo.svg') }}" alt="{{ __('navigation.brand_alt') }}" class="h-12 w-12">
        </a>

        <!-- Desktop menu -->
        <nav class="hidden md:flex items-center gap-6 text-sm font-medium"
            aria-label="{{ __('navigation.main_menu') }}">
            @php
                $items = [
                    ['route' => 'catalog', 'icon' => '📚', 'label' => __('navigation.menu.catalog')],
                    ['route' => 'authors', 'icon' => '👤', 'label' => __('navigation.menu.authors')],
                    ['route' => 'genres', 'icon' => '🗂️', 'label' => __('navigation.menu.genres')],
                    ['route' => 'events', 'icon' => '🎤', 'label' => __('navigation.menu.events')],
                    ['route' => 'blog', 'icon' => '📰', 'label' => __('navigation.menu.blog')],
                    ['route' => 'about', 'icon' => 'ℹ️', 'label' => __('navigation.menu.about')],
                    ['route' => 'contact', 'icon' => '✉️', 'label' => __('navigation.menu.contact')],
                ];
            @endphp

            @foreach ($items as $item)
                <a wire:navigate href="{{ route($item['route']) }}"
                    class="relative flex items-center gap-1.5 text-neutral-800 transition-colors hover:text-black
                          after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:w-0
                          after:h-[2px] after:bg-black after:transition-all after:duration-300
                          hover:after:w-full whitespace-nowrap">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <!-- Right side -->
        <div class="flex items-center gap-3">
            <livewire:search.mini />

            <a wire:navigate href="{{ route('cart') }}"
                class="relative p-2 rounded-lg hover:bg-background focus:ring-2 focus:ring-accent transition"
                aria-label="{{ __('navigation.cart_aria') }}">
                🛒
                <span class="absolute -top-1 -right-1 text-xs bg-accent text-white rounded-full px-1">
                    <livewire:cart.badge />
                </span>
            </a>

            <livewire:language.switcher />

            <!-- Mobile menu button -->
            <button @click="open = !open"
                class="md:hidden p-2 rounded-lg hover:bg-background focus:ring-2 focus:ring-accent transition"
                aria-label="{{ __('navigation.mobile_menu') }}">
                <span x-show="!open">☰</span>
                <span x-show="open">✖</span>
            </button>
        </div>

        <!-- Desktop auth links (hidden on mobile) -->
        <div class="hidden md:flex items-center gap-2">
            @guest
                <a wire:navigate href="{{ route('login') }}" class="px-3 py-2">
                    {{ __('auth.login') }}
                </a>
                <a wire:navigate href="{{ route('register') }}" class="px-3 py-2">
                    {{ __('auth.register') }}
                </a>
            @endguest

            @auth
                <a wire:navigate href="{{ route('profile.overview') }}" class="px-3 py-2">
                    {{ __('auth.profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline"
                    aria-label="{{ __('auth.logout_aria') }}">
                    @csrf
                    <button type="submit" class="px-3 py-2 hover:text-accent transition cursor-pointer">
                        {{ __('auth.logout') }}
                    </button>
                </form>
            @endauth
        </div>

    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-cloak x-transition.origin.top class="md:hidden bg-white border-t shadow-lg z-50">
        <nav class="flex flex-col" aria-label="{{ __('navigation.mobile_menu') }}">
            @foreach ($items as $item)
                <a wire:navigate href="{{ route($item['route']) }}" @click="open = false"
                    class="px-6 py-4 text-lg font-medium text-text border-b border-neutral-200
                          hover:bg-background hover:text-accent transition-colors">
                    {{ $item['icon'] }} {{ $item['label'] }}
                </a>
            @endforeach
            @guest
                <a wire:navigate href="{{ route('login') }}" @click="open = false"
                    class="px-6 py-4 border-b hover:bg-background">{{ __('auth.login') }}</a>
                <a wire:navigate href="{{ route('register') }}" @click="open = false"
                    class="px-6 py-4 border-b hover:bg-background">{{ __('auth.register') }}</a>
            @endguest

            @auth
                <a wire:navigate href="{{ route('profile.overview') }}" @click="open = false"
                    class="px-6 py-4 border-b hover:bg-background">{{ __('auth.profile') }}</a>
                <form method="POST" action="{{ route('logout') }}" class="px-6 py-4 border-b hover:bg-background"
                    @submit="open=false" aria-label="{{ __('auth.logout_aria') }}">
                    @csrf
                    <button type="submit" class="w-full text-left">{{ __('auth.logout') }}</button>
                </form>
            @endauth

        </nav>
    </div>
</header>
