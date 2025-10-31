<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="catalog-title" x-data="{ filtersOpen: false }"
    x-effect="document.body.style.overflow = filtersOpen ? 'hidden' : ''">
    <h1 id="catalog-title" class="text-3xl font-bold mb-6">
        {{ __('shop.title') }}
    </h1>

    <!-- Mobile filter button -->
    <div class="md:hidden mb-4">
        <button @click="filtersOpen = true" class="w-full bg-black text-white py-3 rounded-lg font-semibold text-sm">
            {{ __('shop.filters.title') }}
        </button>
    </div>

    <!-- Layout -->
    <div class="grid grid-cols-1 md:grid-cols-[260px_1fr] gap-8">

        <!-- Desktop sidebar -->
        <aside class="space-y-6 hidden md:block">
            {{-- Authors --}}
            <div>
                <h3 class="font-semibold mb-2">{{ __('shop.filters.author') }}</h3>
                <div class="space-y-1 max-h-60 overflow-y-auto pr-1">
                    @foreach ($authorOptions as $opt)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" wire:model.live="authors" value="{{ $opt['slug'] }}"
                                class="rounded border-gray-300 focus:ring-accent text-accent">
                            <span>{{ $opt['name'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Genres --}}
            <div>
                <h3 class="font-semibold mb-2">{{ __('shop.filters.genre') }}</h3>
                <div class="space-y-1 max-h-60 overflow-y-auto pr-1">
                    @foreach ($genreOptions as $opt)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" wire:model.live="genres" value="{{ $opt['slug'] }}"
                                class="rounded border-gray-300 focus:ring-accent text-accent">
                            <span>{{ $opt['name'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Formats --}}
            <div>
                <h3 class="font-semibold mb-2">{{ __('shop.filters.format') }}</h3>
                <label class="flex items-center gap-2 text-sm mb-1">
                    <input type="checkbox" wire:model.live="formats" value="paper"
                        class="rounded border-gray-300 focus:ring-accent text-accent">
                    <span>{{ __('shop.filters.format_paper') }}</span>
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model.live="formats" value="ebook"
                        class="rounded border-gray-300 focus:ring-accent text-accent">
                    <span>{{ __('shop.filters.format_ebook') }}</span>
                </label>
            </div>

            {{-- Sort --}}
            <div>
                <h3 class="font-semibold mb-2">{{ __('shop.sort.title') }}</h3>
                <select wire:model.live="sort" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="popular">{{ __('shop.sort.popular') }}</option>
                    <option value="new">{{ __('shop.sort.new') }}</option>
                    <option value="price_asc">{{ __('shop.sort.price_asc') }}</option>
                    <option value="price_desc">{{ __('shop.sort.price_desc') }}</option>
                </select>
            </div>

            {{-- Reset --}}
            <button wire:click="resetFilters"
                class="w-full bg-neutral-100 hover:bg-neutral-200 text-sm py-2 rounded-lg font-semibold">
                {{ __('shop.filters.reset') }}
            </button>
        </aside>

        <!-- Books grid -->
        <div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($books as $book)
                    <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col">
                        <div class="relative">
                            <a href="{{ route('book.show', $book['slug']) }}">
                                <img src="{{ $book['cover'] }}" class="w-full h-64 object-cover rounded-t-xl"
                                    loading="lazy">
                            </a>
                        </div>
                        <div class="p-3 flex flex-col gap-2 flex-1">
                            <h2 class="font-medium text-sm sm:text-base line-clamp-2">
                                {{ $book['title'] }}
                            </h2>
                            <div class="text-accent font-bold text-sm sm:text-base leading-tight">
                                {{ number_format($book['price'], 2) }} {{ __('shop.currency') }}
                                @if ($book['price_eur'])
                                    <span class="text-gray-500 text-xs sm:text-sm">
                                        ({{ number_format($book['price_eur'], 2) }} €)
                                    </span>
                                @endif
                            </div>
                            <button wire:click="addToCart({{ $book['id'] }})"
                                class="mt-auto rounded-xl border border-black font-semibold px-3 py-2 text-sm hover:bg-gray-100">
                                {{ __('shop.add_to_cart') }}
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">{{ $booksPaginator->links() }}</div>
        </div>
    </div>

    <!-- MODAL OVERLAY (mobile) -->
    <div x-show="filtersOpen" x-cloak class="fixed inset-0 bg-black/50 z-50 md:hidden" @click="filtersOpen = false"
        @touchmove.prevent x-transition.opacity>
    </div>

    <!-- FULLSCREEN MOBILE FILTER MODAL -->
    <div x-show="filtersOpen" x-cloak class="fixed inset-0 z-50 bg-white md:hidden flex flex-col"
        x-transition.duration.200ms>

        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-bold">{{ __('shop.filters.title') }}</h3>
            <button @click="filtersOpen = false" class="text-sm underline">
                {{ __('shop.filters.close') }}
            </button>
        </div>

        <!-- Scrollable content -->
        <div class="flex-1 overflow-y-auto px-4 pb-32">

            {{-- Authors --}}
            <div class="mt-4">
                <h3 class="font-semibold mb-2">{{ __('shop.filters.author') }}</h3>
                <div class="space-y-2">
                    @foreach ($authorOptions as $opt)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="authors" value="{{ $opt['slug'] }}">
                            <span>{{ $opt['name'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Genres --}}
            <div class="mt-6">
                <h3 class="font-semibold mb-2">{{ __('shop.filters.genre') }}</h3>
                <div class="space-y-2">
                    @foreach ($genreOptions as $opt)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model.live="genres" value="{{ $opt['slug'] }}">
                            <span>{{ $opt['name'] }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Formats --}}
            <div class="mt-6">
                <h3 class="font-semibold mb-2">{{ __('shop.filters.format') }}</h3>
                <label class="flex items-center gap-2 text-sm mb-1">
                    <input type="checkbox" wire:model.live="formats" value="paper">
                    <span>{{ __('shop.filters.format_paper') }}</span>
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model.live="formats" value="ebook">
                    <span>{{ __('shop.filters.format_ebook') }}</span>
                </label>
            </div>

            {{-- Sort --}}
            <div class="mt-6">
                <h3 class="font-semibold mb-2">{{ __('shop.sort.title') }}</h3>
                <select wire:model.live="sort" class="w-full border rounded px-3 py-2 text-sm">
                    <option value="popular">{{ __('shop.sort.popular') }}</option>
                    <option value="new">{{ __('shop.sort.new') }}</option>
                    <option value="price_asc">{{ __('shop.sort.price_asc') }}</option>
                    <option value="price_desc">{{ __('shop.sort.price_desc') }}</option>
                </select>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-4 border-t bg-white" style="padding-bottom: env(safe-area-inset-bottom);">
            <button wire:click="resetFilters"
                class="w-full bg-neutral-100 hover:bg-neutral-200 text-sm py-3 rounded-xl font-semibold">
                {{ __('shop.filters.reset') }}
            </button>
        </div>
    </div>
</section>
