@php use Illuminate\Support\Str; @endphp

<section aria-labelledby="recommended-books" class="my-8">
    <div class="flex items-end justify-between mb-4">
        <h2 id="recommended-books" class="text-xl sm:text-2xl font-semibold text-primary">
            Препоръчани книги
        </h2>
        <a href="{{ route('catalog') }}" class="text-sm text-accent hover:underline transition">
            Виж още
        </a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach ($books as $b)
            @php
                $img = Str::startsWith($b->cover, ['http://', 'https://'])
                    ? $b->cover
                    : asset($b->cover ?? 'storage/images/default-book.jpg');
                $url = route('book.show', $b->slug);
            @endphp

            <article
                class="bg-background rounded-2xl p-3 shadow-sm hover:shadow-lg transition
                       flex flex-col h-full"
                itemscope itemtype="https://schema.org/Book">


                <a href="{{ $url }}" class="block" itemprop="url" aria-label="Детайли за {{ $b->title }}">
                    <img src="{{ $img }}" alt="Корица на книгата {{ $b->title }}" loading="lazy"
                        class="w-full h-40 object-cover rounded-xl mb-3" itemprop="image">
                </a>


                <div class="flex-1">
                    <h3 class="font-medium text-text text-sm sm:text-base line-clamp-2
                               min-h-[2.75rem] sm:min-h-[3rem]"
                        itemprop="name">
                        <a href="{{ $url }}" class="hover:underline">
                            {{ $b->title }}
                        </a>
                    </h3>

                    <p class="text-secondary text-sm mt-1" itemprop="offers" itemscope
                        itemtype="https://schema.org/Offer">
                        <span itemprop="price">{{ number_format($b->price, 2) }}</span> лв.
                        <meta itemprop="priceCurrency" content="BGN" />
                    </p>
                </div>

                <button wire:click="addToCart({{ $b->id }})"
                    class="mt-3 w-full rounded-xl bg-white text-black border border-black font-semibold px-3 py-2
           cursor-pointer active:translate-y-[1px] focus:outline-none focus:ring-2 focus:ring-accent/30">
                    Добави в количка
                </button>

            </article>
        @endforeach
    </div>
</section>
