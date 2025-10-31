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

    <!-- Layout -->
    <div class="grid grid-cols-1 md:grid-cols-[260px_1fr] gap-8">

        <!-- Sidebar -->
        <aside class="space-y-6 hidden md:block">

            {{-- Authors --}}
            <div>
                <h3 class="font-semibold mb-2">{{ __('shop.filters.author') }}</h3>
                <div class="space-y-1 max-h-60 overflow-y-auto pr-1">
                    @foreach ($authorOptions as $opt)
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" wire:model.live="authors" value="{{ $opt['slug'] }}"
                                class="rounded border-gray-300 text-accent focus:ring-accent">
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
                                class="rounded border-gray-300 text-accent focus:ring-accent">
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
                        class="rounded border-gray-300 text-accent focus:ring-accent">
                    <span>{{ __('shop.filters.format_paper') }}</span>
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" wire:model.live="formats" value="ebook"
                        class="rounded border-gray-300 text-accent focus:ring-accent">
                    <span>{{ __('shop.filters.format_ebook') }}</span>
                </label>
            </div>

            {{-- Sort --}}
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

            {{-- Reset --}}
            <button wire:click="resetFilters"
                class="w-full bg-neutral-100 hover:bg-neutral-200 text-sm py-2 rounded-lg font-semibold transition">
                {{ __('shop.filters.reset') }}
            </button>
        </aside>

        <!-- Books -->
        <div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($books as $book)
                    <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col">
                        <div class="relative">
                            <a href="{{ route('book.show', $book['slug'] ?? '') }}">
                                <img src="{{ $book['cover'] }}" class="w-full h-64 object-cover rounded-t-xl"
                                    loading="lazy">
                            </a>
                            <div class="absolute top-2 right-2">
                                <livewire:favorite-button :book-id="$book['id']" wire:key="fav-{{ $book['id'] }}" />
                            </div>
                        </div>

                        <div class="p-3 flex flex-col gap-2 flex-1">
                            <h2 class="font-medium text-sm sm:text-base line-clamp-2">
                                {{ $book['title'] }}
                            </h2>

                            <span class="text-accent font-bold">
                                {{ number_format($book['price'], 2) }} {{ __('shop.currency') }}
                            </span>

                            <button wire:click="addToCart({{ $book['id'] }})"
                                class="mt-auto rounded-xl border border-black font-semibold px-3 py-2 text-sm hover:bg-gray-100">
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
    </div>

    {{-- <!-- Mobile slide filters -->
    <div x-show="filtersOpen" class="fixed inset-0 bg-black/50 z-50 flex md:hidden" x-cloak>
        <div @click.away="filtersOpen = false" class="bg-white w-80 h-full p-4 overflow-y-auto shadow-xl">
            @include('livewire.pages.catalog-mobile-filters')
        </div> --}}
    </div>
</section>
