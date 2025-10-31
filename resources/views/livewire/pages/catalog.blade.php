<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="catalog-title">
    <h1 id="catalog-title" class="text-3xl font-bold mb-6">
        {{ __('shop.title') }}
    </h1>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">

            <select wire:model.live="author" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="0">{{ __('shop.filters.author_all') }}</option>
                @foreach ($authorOptions as $opt)
                    <option value="{{ $opt['slug'] }}">{{ $opt['name'] }}</option>
                @endforeach
            </select>

            <select wire:model.live="genre" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="0">{{ __('shop.filters.genre_all') }}</option>
                @foreach ($genreOptions as $opt)
                    <option value="{{ $opt['slug'] }}">{{ $opt['name'] }}</option>
                @endforeach
            </select>

            <select wire:model.live="format" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="0">{{ __('shop.filters.format_all') }}</option>
                <option value="paper">{{ __('shop.filters.format_paper') }}</option>
                <option value="ebook">{{ __('shop.filters.format_ebook') }}</option>
            </select>
        </div>

        <div class="w-full sm:w-auto">
            <select wire:model.live="sort" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="popular">{{ __('shop.sort.popular') }}</option>
                <option value="new">{{ __('shop.sort.new') }}</option>
                <option value="price_asc">{{ __('shop.sort.price_asc') }}</option>
                <option value="price_desc">{{ __('shop.sort.price_desc') }}</option>
            </select>
        </div>
    </div>


    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($books as $book)
            <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col" itemscope
                itemtype="https://schema.org/Book">

                <div class="relative">
                    <a href="{{ route('book.show', $book['slug'] ?? '') }}"
                        aria-label="{{ __('shop.aria.view_details', ['title' => $book['title']]) }}">
                        <img src="{{ $book['cover'] }}" alt="{{ __('shop.alt.cover', ['title' => $book['title']]) }}"
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

                    <span class="text-accent font-bold" itemprop="offers" itemscope
                        itemtype="https://schema.org/AggregateOffer">
                        <span itemscope itemtype="https://schema.org/Offer">
                            <meta itemprop="priceCurrency" content="BGN">
                            <span itemprop="price">{{ number_format($book['price'], 2) }}</span>
                            {{ __('shop.currency') }}
                        </span>

                        @if (!empty($book['price_eur']))
                            <br>
                            <span class="text-sm text-gray-500" itemscope itemtype="https://schema.org/Offer">
                                <meta itemprop="priceCurrency" content="EUR">
                                <span itemprop="price">{{ number_format($book['price_eur'], 2) }}</span> €
                            </span>
                        @endif
                    </span>

                    <button wire:click="addToCart({{ (int) $book['id'] }})"
                        class="mt-auto rounded-xl bg-white text-black border border-black font-semibold px-3 py-2 text-sm transition cursor-pointer hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-accent/40"
                        aria-label="{{ __('shop.aria.add_to_cart', ['title' => $book['title']]) }}">
                        {{ __('shop.add_to_cart') }}
                    </button>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $booksPaginator->links() }}
    </div>
</section>
