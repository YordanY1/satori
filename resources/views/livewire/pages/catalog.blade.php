<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="catalog-title">
    <h1 id="catalog-title" class="text-3xl font-bold mb-6">
        {{ __('shop.title') }}
    </h1>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        {{-- Filters --}}
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <select wire:model.live="filters.author" class="border rounded-lg px-3 py-2 w-full sm:w-auto">
                <option value="">{{ __('shop.filters.author_all') }}</option>
                @foreach ($authorOptions as $opt)
                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filters.genre" class="border rounded-lg px-3 py-2 w-full sm:w-auto">
                <option value="">{{ __('shop.filters.genre_all') }}</option>
                @foreach ($genreOptions as $opt)
                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="filters.format" class="border rounded-lg px-3 py-2 w-full sm:w-auto">
                <option value="">{{ __('shop.filters.format_all') }}</option>
                <option value="paper">{{ __('shop.filters.format_paper') }}</option>
                <option value="ebook">{{ __('shop.filters.format_ebook') }}</option>
            </select>
        </div>

        {{-- Sort --}}
        <div class="w-full sm:w-auto">
            <select wire:model.live="sort" class="border rounded-lg px-3 py-2 w-full sm:w-auto">
                <option value="popular">{{ __('shop.sort.popular') }}</option>
                <option value="new">{{ __('shop.sort.new') }}</option>
                <option value="price_asc">{{ __('shop.sort.price_asc') }}</option>
                <option value="price_desc">{{ __('shop.sort.price_desc') }}</option>
            </select>
        </div>
    </div>

    {{-- Books Grid --}}
    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
        @foreach ($books as $book)
            <article
                class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition flex flex-col border border-gray-100">
                <div class="relative">
                    <a href="{{ route('book.show', $book['slug'] ?? '') }}">
                        <img src="{{ $book['cover'] }}" alt="{{ __('shop.alt.cover', ['title' => $book['title']]) }}"
                            class="w-full h-60 sm:h-72 object-cover rounded-t-2xl" loading="lazy">
                    </a>

                    <div class="absolute top-2 right-2">
                        <livewire:favorite-button :book-id="$book['id']" wire:key="fav-catalog-{{ $book['id'] }}" />
                    </div>
                </div>

                <div class="p-4 flex flex-col flex-1 gap-3">
                    <h2 class="font-semibold text-base leading-snug line-clamp-2 text-gray-900">
                        {{ $book['title'] }}
                    </h2>

                    <span class="text-lg font-bold text-accent">
                        {{ number_format($book['price'], 2) }} {{ __('shop.currency') }}

                        @if (!empty($book['price_eur']))
                            <br>
                            <span class="text-sm text-gray-500 font-medium">
                                {{ number_format($book['price_eur'], 2) }} €
                            </span>
                        @endif
                    </span>

                    <button wire:click="addToCart({{ (int) $book['id'] }})"
                        class="mt-auto w-full rounded-xl bg-accent text-white font-medium px-4 py-2.5 text-sm shadow-sm hover:bg-accent/90 active:scale-[0.98] transition">
                        {{ __('shop.add_to_cart') }}
                    </button>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $booksPaginator->links() }}
    </div>
</section>
