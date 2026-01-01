<section class="my-8" itemscope itemtype="https://schema.org/Book">
    @if ($book->id > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
            <div class="relative">
                <img src="{{ $book->cover_url }}" alt="{{ __('book.cover', ['title' => $book->title]) }}"
                    class="rounded-2xl shadow-lg w-full h-auto" loading="lazy" itemprop="image">
                <livewire:favorite-button :book-id="$book->id" wire:key="fav-hero-{{ $book->id }}" />
            </div>

            <div>
                <h2 class="text-xl sm:text-2xl font-semibold mb-2 text-primary">
                    {{ __('book.book_of_month') }}
                </h2>

                <h3 class="text-lg sm:text-xl font-medium text-text" itemprop="name">
                    {{ $book->title }}
                </h3>

                <p class="mt-2 text-neutral-700 leading-relaxed" itemprop="description">
                    {{ $book->description }}
                </p>

                <p class="text-primary text-2xl font-bold mt-4" itemprop="offers" itemscope
                    itemtype="https://schema.org/AggregateOffer">

                    {{-- EUR first --}}
                    @if (!empty($book->price_eur))
                        <span itemscope itemtype="https://schema.org/Offer">
                            <span itemprop="price">{{ number_format($book->price_eur, 2) }}</span> €
                            <meta itemprop="priceCurrency" content="EUR" />
                        </span>
                        <br>
                    @endif

                    {{-- BGN second --}}
                    <span itemscope itemtype="https://schema.org/Offer" class="text-base text-gray-500">
                        <span itemprop="price">{{ number_format($book->price, 2) }}</span>
                        {{ __('catalog.currency') }}
                        <meta itemprop="priceCurrency" content="BGN" />
                    </span>
                </p>


                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <button wire:click="addToCart({{ $book->id }})"
                        class="rounded-xl bg-white text-black border border-black font-semibold px-4 py-2
                            cursor-pointer active:translate-y-[1px] focus:outline-none focus:ring-2 focus:ring-accent/30">
                        {{ __('catalog.add_to_cart') }}
                    </button>

                    @if ($book->excerpt_url)
                        <a href="{{ $book->excerpt_url }}" class="text-sm text-secondary hover:underline transition"
                            aria-label="{{ __('book.excerpt_aria', ['title' => $book->title]) }}" target="_blank"
                            rel="noopener">
                            📄 {{ __('book.excerpt') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl shadow-md">
            <h2 class="text-2xl font-semibold text-primary mb-2">📚 {{ __('book.book_of_month') }}</h2>
            <p class="text-lg text-neutral-700">Очаквайте скоро новата книга на месеца!</p>
        </div>
    @endif
</section>
