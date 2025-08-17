<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="genres-title">
    <h1 id="genres-title" class="text-3xl font-bold mb-6">Жанрове / Теми</h1>
    <p class="text-neutral-700 mb-6">Открий книги според темата, която те вълнува.</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach ($genres as $g)
            <article
                class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition flex flex-col items-center text-center"
                itemscope itemtype="https://schema.org/CategoryCodeSet">
                <a href="{{ route('genre.show', $g['slug']) }}" aria-label="Виж книги в категория {{ $g['name'] }}">
                    <div class="text-4xl mb-3">{{ $g['icon'] }}</div>
                    <h2 class="font-semibold text-base sm:text-lg" itemprop="name">
                        {{ $g['name'] }}
                    </h2>
                </a>
            </article>
        @endforeach
    </div>
</section>
