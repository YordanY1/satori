<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <a href="{{ route('catalog') }}" class="text-sm text-accent hover:underline">
            ← {{ __('genres.back_to_catalog') }}
        </a>
    </div>

    <h1 class="text-3xl font-bold mb-2">
        {{ $genre['name'] }}
    </h1>

    @if (!empty($genre['desc']))
        <p class="text-neutral-700 mb-8 max-w-3xl leading-relaxed">
            {{ $genre['desc'] }}
        </p>
    @endif

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($genre['books'] as $b)
            <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col" itemscope
                itemtype="https://schema.org/Book">
                <div class="relative">
                    <a href="{{ route('book.show', $b['slug']) }}"
                        aria-label="{{ __('shop.aria.view_details', ['title' => $b['title']]) }}">
                        <img src="{{ $b['cover'] }}" alt="{{ __('book.cover', ['title' => $b['title']]) }}"
                            class="w-full h-56 sm:h-64 md:h-72 object-cover rounded-t-xl" loading="lazy"
                            itemprop="image">
                    </a>

                    <div class="absolute top-2 right-2">
                        <livewire:favorite-button :book-id="$b['id']" wire:key="fav-genre-{{ $b['id'] }}" />
                    </div>
                </div>

                <div class="p-3 flex flex-col gap-2 flex-1">
                    <h2 class="font-medium text-sm sm:text-base line-clamp-2" itemprop="name">
                        {{ $b['title'] }}
                    </h2>

                    <span class="text-accent font-bold" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="BGN">
                        <span itemprop="price">{{ number_format($b['price'], 2) }}</span> {{ __('shop.currency') }}
                    </span>

                    <button wire:click="addToCart({{ (int) $b['id'] }})"
                        class="mt-auto rounded-xl bg-white text-black border border-black font-semibold px-3 py-2 text-sm
                               transition cursor-pointer hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-accent/40"
                        aria-label="{{ __('shop.aria.add_to_cart', ['title' => $b['title']]) }}">
                        {{ __('shop.add_to_cart') }}
                    </button>
                </div>
            </article>
        @endforeach
    </div>
</section>
