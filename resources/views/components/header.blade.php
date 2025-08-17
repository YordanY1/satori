<header class="border-b bg-white shadow-sm" role="banner" x-data="{ open: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

        <a href="{{ url('/') }}" class="flex items-center gap-3 group" aria-label="Начало – Сатори Ко">
            <img src="{{ asset('logo.svg') }}" alt="Satori – Онлайн книжарница" class="h-12 w-12">
            <span
                class="hidden sm:inline font-bold tracking-wide text-primary group-hover:text-accent transition-colors text-lg sm:text-xl">
                Сатори Ко
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm font-medium" aria-label="Главно меню">
            @foreach ([['route' => 'catalog', 'icon' => '📚', 'label' => 'Книги'], ['route' => 'authors', 'icon' => '👤', 'label' => 'Автори'], ['route' => 'genres', 'icon' => '🗂️', 'label' => 'Жанрове'], ['route' => 'events', 'icon' => '🎤', 'label' => 'Събития'], ['route' => 'blog', 'icon' => '📰', 'label' => 'Блог'], ['route' => 'about', 'icon' => 'ℹ️', 'label' => 'За нас'], ['route' => 'contact', 'icon' => '✉️', 'label' => 'Контакт']] as $item)
                <a wire:navigate href="{{ route($item['route']) }}"
                    class="relative flex items-center gap-1.5 text-neutral-800 transition-colors hover:text-black
                   after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:w-0
                   after:h-[2px] after:bg-black after:transition-all after:duration-300
                   hover:after:w-full">
                    <span>{{ $item['icon'] }}</span>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>


        <div class="flex items-center gap-3">
            @livewire('search.mini')

            <a href="{{ route('cart') }}"
                class="relative p-2 rounded-lg hover:bg-background focus:ring-2 focus:ring-accent transition"
                aria-label="Количка с продукти">
                🛒
                <span class="absolute -top-1 -right-1 text-xs bg-accent text-white rounded-full px-1">
                    <livewire:cart.badge />
                </span>
            </a>

            <livewire:language.switcher />

            <button @click="open = !open"
                class="md:hidden p-2 rounded-lg hover:bg-background focus:ring-2 focus:ring-accent transition"
                aria-label="Отвори мобилното меню">
                <span x-show="!open">☰</span>
                <span x-show="open">✖</span>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition.origin.top class="md:hidden bg-white border-t shadow-lg z-50">
        <nav class="flex flex-col" aria-label="Мобилно меню">
            @foreach ([['route' => 'catalog', 'label' => '📚 Книги'], ['route' => 'authors', 'label' => '👤 Автори'], ['route' => 'genres', 'label' => '🗂️ Жанрове'], ['route' => 'events', 'label' => '🎤 Събития'], ['route' => 'blog', 'label' => '📰 Блог'], ['route' => 'about', 'label' => 'ℹ️ За нас'], ['route' => 'contact', 'label' => '✉️ Контакт']] as $item)
                <a wire:navigate href="{{ route($item['route']) }}" @click="open = false"
                    class="px-6 py-4 text-lg font-medium text-text border-b border-neutral-200 hover:bg-background hover:text-accent transition-colors">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </div>

</header>
