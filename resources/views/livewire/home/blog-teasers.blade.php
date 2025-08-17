<section aria-labelledby="blog-section" class="my-8">
    <div class="flex items-end justify-between mb-4">
        <h2 id="blog-section" class="text-xl sm:text-2xl font-semibold text-primary">От блога</h2>
        <a href="{{ route('blog') }}" class="text-sm text-accent hover:underline transition">Виж всички</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach ($posts as $p)
            <article class="bg-background rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col"
                itemscope itemtype="https://schema.org/BlogPosting">

                <a href="{{ $p['url'] }}" itemprop="url">
                    <img src="{{ $p['cover'] }}" alt="Корица към статията: {{ $p['title'] }}"
                        class="w-full h-40 object-cover" itemprop="image">
                </a>

                <div class="p-4 flex flex-col flex-1">
                    <h3 class="font-semibold text-text text-base sm:text-lg mb-1" itemprop="headline">
                        <a href="{{ $p['url'] }}" class="hover:text-accent transition" itemprop="mainEntityOfPage">
                            {{ $p['title'] }}
                        </a>
                    </h3>

                    <p class="text-sm text-secondary line-clamp-2 mb-3" itemprop="description">
                        {{ $p['excerpt'] }}
                    </p>

                    @if (!empty($p['date']))
                        <meta itemprop="datePublished" content="{{ $p['date'] }}">
                        <meta itemprop="dateModified" content="{{ $p['date'] }}">
                    @endif

                    <div class="mt-auto pt-3">
                        <a href="{{ $p['url'] }}"
                            class="inline-block w-full text-center px-4 py-2 text-sm font-medium text-text border border-accent rounded-lg hover:bg-accent/10 hover:text-text transition"
                            aria-label="Прочети още за {{ $p['title'] }}">
                            Прочети още →
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
