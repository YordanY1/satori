<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="book-title" itemscope
    itemtype="https://schema.org/Book">

    <h1 id="book-title" class="text-3xl font-bold mb-6" itemprop="name">
        {{ $book['title'] }}
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


        <div>
            <img src="{{ $book['cover'] }}" alt="Корицата на книгата {{ $book['title'] }}"
                class="w-full h-auto rounded-xl shadow-md" itemprop="image">
        </div>

        <div class="flex flex-col gap-5">


            <p class="text-lg text-text">
                Автор:
                <a href="{{ route('author.show', $book['author']['slug']) }}"
                    class="font-semibold underline hover:no-underline" itemprop="author">
                    {{ $book['author']['name'] }}
                </a>
            </p>


            <div class="flex items-center gap-6">
                <p class="text-2xl font-bold text-accent" itemprop="offers" itemscope
                    itemtype="https://schema.org/Offer">
                    <meta itemprop="priceCurrency" content="BGN">
                    <span itemprop="price">{{ number_format($book['price'], 2) }}</span> лв.
                </p>

                <p class="text-text">
                    Формат:
                    <span class="font-medium">
                        {{ $book['format'] === 'paper' ? 'Хартиена' : 'Електронна' }}
                    </span>
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button wire:click="addToCart(1)"
                    class="rounded-xl bg-white text-black border border-black font-semibold px-5 py-3 shadow-sm
                               hover:bg-neutral-100 focus-visible:ring-2 focus-visible:ring-accent/40 transition cursor-pointer">
                    Добави в количка
                </button>

                <a href="{{ route('checkout') }}"
                    class="rounded-xl bg-accent text-black font-semibold px-5 py-3 shadow-sm border border-accent/70
                          hover:bg-accent/90 focus-visible:ring-2 focus-visible:ring-accent/40 transition">
                    Поръчай сега
                </a>

                @if (!empty($book['excerpt_url']))
                    <button x-data @click="$dispatch('open-excerpt')"
                        class="rounded-xl bg-white text-black border border-black font-medium px-5 py-3
                                   hover:bg-neutral-100 focus-visible:ring-2 focus-visible:ring-accent/40 transition">
                        Прочети откъс
                    </button>
                @endif
            </div>


            <div class="flex items-center gap-3 pt-2">
                <span class="text-neutral-600">Сподели:</span>
                <a class="underline hover:no-underline"
                    href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                    target="_blank" rel="noopener">Facebook</a>
                <a class="underline hover:no-underline"
                    href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($book['title']) }}"
                    target="_blank" rel="noopener">X</a>
                <a class="underline hover:no-underline"
                    href="https://pinterest.com/pin/create/button/?url={{ urlencode(request()->url()) }}&media={{ urlencode($book['cover']) }}&description={{ urlencode($book['title']) }}"
                    target="_blank" rel="noopener">Pinterest</a>
            </div>


            <div class="flex items-center gap-2 text-neutral-700">
                <div aria-hidden="true">⭐</div>
                <span>
                    {{ number_format($book['rating_avg'], 1) }}/5 ({{ $book['rating_count'] }} оценки)
                </span>
                <meta itemprop="aggregateRating"
                    content="{{ json_encode(['@type' => 'AggregateRating', 'ratingValue' => $book['rating_avg'], 'reviewCount' => $book['rating_count']], JSON_UNESCAPED_UNICODE) }}">
            </div>
        </div>
    </div>


    <section class="mt-10" aria-labelledby="desc-title">
        <h2 id="desc-title" class="text-2xl font-semibold mb-3">Описание</h2>
        <div class="prose max-w-none text-text" itemprop="description">
            {!! nl2br(e($book['description'])) !!}
        </div>
    </section>

    <section class="mt-10" aria-labelledby="reviews-title">
        <h2 id="reviews-title" class="text-2xl font-semibold mb-4">Ревюта и оценки</h2>

        @forelse($book['reviews'] as $review)
            <article class="border-b border-neutral-200 py-4">
                <h3 class="font-semibold text-text">{{ $review['user'] }}</h3>
                <p class="text-yellow-600" aria-label="Оценка: {{ $review['rating'] }} от 5">
                    {{ str_repeat('★', $review['rating']) }}{{ str_repeat('☆', 5 - $review['rating']) }}
                </p>
                <p class="text-neutral-800">{{ $review['content'] }}</p>
            </article>
        @empty
            <p class="text-neutral-600">Все още няма ревюта за тази книга.</p>
        @endforelse
    </section>

    @if (!empty($book['excerpt_url']))
        <div x-data="{ open: false }" x-on:open-excerpt.window="open = true" x-show="open" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <div x-show="open" class="absolute inset-0 bg-black/60" @click="open = false"></div>

            <div x-show="open" x-transition
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl h-[80vh] flex flex-col">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="font-semibold text-lg">Откъс: {{ $book['title'] }}</h3>
                    <button class="p-2 rounded hover:bg-neutral-100" @click="open = false"
                        aria-label="Затвори">✖</button>
                </div>
                <div class="flex-1">
                    <iframe src="{{ $book['excerpt_url'] }}" class="w-full h-full" title="Откъс (PDF)"></iframe>
                </div>
            </div>
        </div>
    @endif

</section>
