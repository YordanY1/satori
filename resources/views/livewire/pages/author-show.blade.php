<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="author-name" itemscope
    itemtype="https://schema.org/Person">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-1">
            @if (!empty($author['photo']))
                <img src="{{ asset('storage/' . ltrim($author['photo'], '/')) }}" alt="Снимка на {{ $author['name'] }}"
                    class="w-full h-auto rounded-2xl shadow-md mb-4" itemprop="image">
            @endif

            <h1 id="author-name" class="text-3xl font-bold" itemprop="name">
                {{ $author['name'] }}
            </h1>

            <ul class="mt-4 text-sm text-neutral-600 space-y-1">
                @if (!empty($author['books']))
                    <li>📚 Книги: {{ count($author['books']) }}</li>
                @endif
                @if (!empty($author['quotes']))
                    <li>💬 Цитати: {{ count($author['quotes']) }}</li>
                @endif
                @if (!empty($author['videos']))
                    <li>🎬 Видеа: {{ count($author['videos']) }}</li>
                @endif
                @if (!empty($author['interviews']))
                    <li>🎙 Интервюта: {{ count($author['interviews']) }}</li>
                @endif
            </ul>
        </div>

        <div class="md:col-span-2">

            @if (!empty($author['bio']))
                <h2 class="text-2xl font-semibold mb-3">Биография</h2>
                <div class="prose max-w-none text-text" itemprop="description">
                    {!! nl2br(e($author['bio'])) !!}
                </div>
            @endif


            @if (!empty($author['quotes']))
                <h2 class="text-2xl font-semibold mt-8 mb-3">
                    Цитати <span class="text-neutral-500">({{ count($author['quotes']) }})</span>
                </h2>
                <ul class="space-y-3">
                    @foreach ($author['quotes'] as $q)
                        <li>
                            <blockquote class="border-l-4 border-neutral-300 pl-4 italic text-neutral-800"
                                itemprop="quotation">
                                “{{ $q }}”
                            </blockquote>
                        </li>
                    @endforeach
                </ul>
            @endif


            @if (!empty($author['videos']))
                <h2 class="text-2xl font-semibold mt-8 mb-3">
                    Видео представяне <span class="text-neutral-500">({{ count($author['videos']) }})</span>
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($author['videos'] as $v)
                        @if (($v['type'] ?? null) === 'youtube' && !empty($v['id']))
                            <article class="bg-white rounded-2xl p-3 shadow-sm" itemscope
                                itemtype="https://schema.org/VideoObject">
                                <h3 class="font-medium mb-2" itemprop="name">{{ $v['title'] ?? 'Видео' }}</h3>
                                <meta itemprop="thumbnailUrl"
                                    content="https://i.ytimg.com/vi/{{ $v['id'] }}/hqdefault.jpg">
                                <meta itemprop="embedUrl" content="https://www.youtube.com/embed/{{ $v['id'] }}">
                                <meta itemprop="contentUrl"
                                    content="https://www.youtube.com/watch?v={{ $v['id'] }}">
                                <div class="aspect-video rounded-lg overflow-hidden">
                                    <iframe class="w-full h-full"
                                        src="https://www.youtube.com/embed/{{ $v['id'] }}?rel=0&modestbranding=1"
                                        title="{{ $v['title'] ?? 'Видео' }}" loading="lazy"
                                        allow="accelerometer; autoplay; encrypted-media; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                                <a href="https://www.youtube.com/watch?v={{ $v['id'] }}"
                                    class="mt-3 inline-flex items-center gap-2 text-accent hover:underline"
                                    target="_blank" rel="noopener" itemprop="url">
                                    Гледай в YouTube
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </article>
                        @endif
                    @endforeach
                </div>
            @endif


            @if (!empty($author['interviews']))
                <h2 class="text-2xl font-semibold mt-8 mb-3">
                    Интервюта и участия <span class="text-neutral-500">({{ count($author['interviews']) }})</span>
                </h2>
                <ul class="list-disc ml-6 space-y-2">
                    @foreach ($author['interviews'] as $i)
                        @if (!empty($i['title']) && !empty($i['url']))
                            <li>
                                <a href="{{ $i['url'] }}" class="underline hover:no-underline" target="_blank"
                                    rel="noopener">
                                    {{ $i['title'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if (!empty($author['books']))
        <section class="mt-12" aria-labelledby="author-books">
            <div class="flex items-end justify-between mb-4">
                <h2 id="author-books" class="text-2xl font-semibold text-primary">
                    Книги <span class="text-neutral-500">({{ count($author['books']) }})</span>
                </h2>
                <a href="{{ route('catalog') }}" class="text-sm text-accent hover:underline transition">Виж всички</a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($author['books'] as $b)
                    @continue(empty($b['slug']) || empty($b['title']))
                    <article class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-md transition flex flex-col"
                        itemscope itemtype="https://schema.org/Book">
                        <a href="{{ route('book.show', $b['slug']) }}" aria-label="Виж {{ $b['title'] }}"
                            itemprop="url">
                            @if (!empty($b['cover']))
                                <img src="{{ $b['cover'] }}" alt="Корица на {{ $b['title'] }}"
                                    class="w-full h-40 sm:h-48 object-cover rounded-xl mb-3" loading="lazy"
                                    itemprop="image">
                            @else
                                <div
                                    class="w-full h-40 sm:h-48 bg-neutral-100 rounded-xl mb-3 grid place-items-center text-neutral-400">
                                    Няма корица
                                </div>
                            @endif
                        </a>

                        <h3 class="font-medium text-sm sm:text-base line-clamp-2 mb-1" itemprop="name">
                            {{ $b['title'] }}
                        </h3>

                        @if (isset($b['price']))
                            <p class="text-secondary text-sm mb-2" itemprop="offers" itemscope
                                itemtype="https://schema.org/Offer">
                                <meta itemprop="priceCurrency" content="BGN">
                                <span itemprop="price">{{ number_format((float) $b['price'], 2) }}</span> лв.
                            </p>
                        @endif

                        @if (!empty($b['id']))
                            <button wire:click="addToCart({{ (int) $b['id'] }})"
                                class="mt-auto w-full rounded-xl bg-white text-black py-2 text-sm font-bold shadow-sm
                                       focus-visible:ring-2 focus-visible:ring-accent/40 transition cursor-pointer border border-black">
                                Добави в количка
                            </button>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

</section>
