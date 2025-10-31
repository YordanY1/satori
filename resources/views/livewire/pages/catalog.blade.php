<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="catalog-title" x-data="{ filtersOpen: false }">
    <h1 id="catalog-title" class="text-3xl font-bold mb-6">
        {{ __('shop.title') }}
    </h1>

    <!-- Mobile filter button -->
    <div class="md:hidden mb-4">
        <button @click="filtersOpen = true" class="w-full bg-black text-white py-3 rounded-lg font-semibold text-sm">
            {{ __('shop.filters.title') }}
        </button>
    </div>

    <!-- Desktop Filter Bar -->
    <div class="hidden md:flex flex-wrap gap-3 mb-6">

        <!-- Authors Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="border bg-white px-3 py-2 rounded-lg text-sm shadow-sm">
                {{ __('shop.filters.author') }}
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute z-20 bg-white border rounded-lg shadow-md p-3 mt-2 max-h-64 overflow-y-auto w-56">
                @foreach ($authorOptions as $opt)
                    <label class="flex items-center gap-2 p-1 text-sm cursor-pointer">
                        <input type="checkbox" wire:model.live="authors" value="{{ $opt['slug'] }}"
                            class="rounded border-gray-300 text-accent focus:ring-accent">
                        <span>{{ $opt['name'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Genres Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="border bg-white px-3 py-2 rounded-lg text-sm shadow-sm">
                {{ __('shop.filters.genre') }}
            </button>

            <div x-show="open" @click.away="open = false"
                class="absolute z-20 bg-white border rounded-lg shadow-md p-3 mt-2 max-h-64 overflow-y-auto w-56">
                @foreach ($genreOptions as $opt)
                    <label class="flex items-center gap-2 p-1 text-sm cursor-pointer">
                        <input type="checkbox" wire:model.live="genres" value="{{ $opt['slug'] }}"
                            class="rounded border-gray-300 text-accent focus:ring-accent">
                        <span>{{ $opt['name'] }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Format -->
        <select wire:model.live="formats" class="border rounded-lg px-3 py-2 text-sm bg-white shadow-sm">
            <option value="">{{ __('shop.filters.format') }}</option>
            <option value="paper">{{ __('shop.filters.format_paper') }}</option>
            <option value="ebook">{{ __('shop.filters.format_ebook') }}</option>
        </select>

        <!-- Sort -->
        <select wire:model.live="sort" class="border rounded-lg px-3 py-2 text-sm bg-white shadow-sm">
            <option value="popular">{{ __('shop.sort.popular') }}</option>
            <option value="new">{{ __('shop.sort.new') }}</option>
            <option value="price_asc">{{ __('shop.sort.price_asc') }}</option>
            <option value="price_desc">{{ __('shop.sort.price_desc') }}</option>
        </select>

        <!-- Reset -->
        <button wire:click="resetFilters" class="text-sm underline px-2">
            {{ __('shop.filters.reset') }}
        </button>
    </div>

    <!-- Books Grid -->
    <div class="mt-20 sm:mt-28 md:mt-32">

        <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 gap-5">
            @foreach ($books as $book)
                <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col" itemscope
                    itemtype="https://schema.org/Book">

                    <div class="relative">
                        <a href="{{ route('book.show', $book['slug'] ?? '') }}"
                            aria-label="{{ __('shop.aria.view_details', ['title' => $book['title']]) }}">
                            <img src="{{ $book['cover'] }}"
                                alt="{{ __('shop.alt.cover', ['title' => $book['title']]) }}"
                                class="w-full h-56 sm:h-64 md:h-72 object-cover rounded-t-xl" loading="lazy"
                                itemprop="image">
                        </a>
                        <div class="absolute top-2 right-2">
                            <livewire:favorite-button :book-id="$book['id']" wire:key="fav-catalog-{{ $book['id'] }}" />
                        </div>
                    </div>

                    <div class="p-3 flex flex-col gap-2 flex-1">
                        <h2 class="font-medium text-sm sm:text-base line-clamp-2" itemprop="name">
                            {{ $book['title'] }}
                        </h2>

                        <span class="text-accent font-bold">
                            {{ number_format($book['price'], 2) }} {{ __('shop.currency') }}
                        </span>

                        <button wire:click="addToCart({{ (int) $book['id'] }})"
                            class="mt-auto rounded-xl bg-white text-black border border-black font-semibold px-3 py-2 text-sm transition hover:bg-gray-100">
                            {{ __('shop.add_to_cart') }}
                        </button>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $booksPaginator->links() }}
        </div>
    </div>

    <!-- Mobile slide-over stays same -->
    <div x-show="filtersOpen" class="fixed inset-0 bg-black/50 z-50 flex md:hidden" x-cloak>
        <div @click.away="filtersOpen = false"
            class="mr-auto bg-white w-80 h-full p-4 overflow-y-scroll overscroll-contain shadow-xl absolute left-0 top-0"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">{{ __('shop.filters.title') }}</h2>
                <button @click="filtersOpen = false" class="text-sm underline">
                    {{ __('shop.filters.close') }}
                </button>
            </div>

            {{-- Mobile filter content (same as before) --}}
            <div class="space-y-6">

                <div>
                    <h3 class="font-semibold mb-2">{{ __('shop.filters.author') }}</h3>
                    <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                        @foreach ($authorOptions as $opt)
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" wire:model.live="authors" value="{{ $opt['slug'] }}"
                                    class="rounded border-gray-300 text-accent focus:ring-accent">
                                <span>{{ $opt['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">{{ __('shop.filters.genre') }}</h3>
                    <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                        @foreach ($genreOptions as $opt)
                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox" wire:model.live="genres" value="{{ $opt['slug'] }}"
                                    class="rounded border-gray-300 text-accent focus:ring-accent">
                                <span>{{ $opt['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">{{ __('shop.filters.format') }}</h3>
                    <label class="flex items-center gap-2 text-sm mb-1">
                        <input type="checkbox" wire:model.live="formats" value="paper"
                            class="rounded border-gray-300 text-accent focus:ring-accent">
                        <span>{{ __('shop.filters.format_paper') }}</span>
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model.live="formats" value="ebook"
                            class="rounded border-gray-300 text-accent focus:ring-accent">
                        <span>{{ __('shop.filters.format_ebook') }}</span>
                    </label>
                </div>

                <div>
                    <h3 class="font-semibold mb-2">{{ __('shop.sort.title') }}</h3>
                    <select wire:model.live="sort"
                        class="w-full border rounded px-3 py-2 text-sm focus:ring-accent focus:border-accent">
                        <option value="popular">{{ __('shop.sort.popular') }}</option>
                        <option value="new">{{ __('shop.sort.new') }}</option>
                        <option value="price_asc">{{ __('shop.sort.price_asc') }}</option>
                        <option value="price_desc">{{ __('shop.sort.price_desc') }}</option>
                    </select>
                </div>

                <button wire:click="resetFilters"
                    class="w-full bg-neutral-100 hover:bg-neutral-200 text-sm py-2 rounded-lg font-semibold transition">
                    {{ __('shop.filters.reset') }}
                </button>
            </div>
        </div>
    </div>

</section>
