<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-4">{{ $genre['name'] }}</h1>
    <p class="text-neutral-700 mb-8">{{ $genre['desc'] }}</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach ($genre['books'] as $b)
            <article class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-md transition flex flex-col" itemscope
                itemtype="https://schema.org/Book">

                <div class="relative">
                    <a href="{{ route('book.show', $b['slug']) }}"
                        aria-label="{{ __('shop.aria.view_details', ['title' => $b['title']]) }}">
                        <img src="{{ $b['cover'] }}" alt="{{ __('book.cover', ['title' => $b['title']]) }}"
                            class="w-full h-40 sm:h-48 object-cover rounded-xl mb-3" loading="lazy" itemprop="image">
                    </a>

                    <div class="absolute top-2 right-2">
                        <livewire:favorite-button :book-id="$b['id']" wire:key="fav-card-{{ $b['id'] }}" />
                    </div>
                </div>

                <h2 class="font-medium text-sm sm:text-base line-clamp-2 mb-1" itemprop="name">
                    {{ $b['title'] }}
                </h2>

                <p class="text-secondary text-sm mb-2" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <meta itemprop="priceCurrency" content="BGN">
                    <span itemprop="price">{{ number_format($b['price'], 2) }}</span> {{ __('shop.currency') }}
                </p>

                <button wire:click="addToCart({{ (int) $b['id'] }})"
                    class="mt-auto w-full rounded-xl bg-white text-black py-2 text-sm font-bold shadow-sm border border-black
                   focus-visible:ring-2 focus-visible:ring-accent/40 transition cursor-pointer"
                    aria-label="{{ __('shop.aria.add_to_cart', ['title' => $b['title']]) }}">
                    {{ __('shop.add_to_cart') }}
                </button>
            </article>
        @endforeach
    </div>
</section>
