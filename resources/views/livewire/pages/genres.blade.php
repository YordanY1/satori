<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="genres-title">
    <h1 id="genres-title" class="text-3xl font-bold mb-6">
        {{ __('genres.title') }}
    </h1>

    <p class="text-neutral-700 mb-6">
        {{ __('genres.subtitle') }}
    </p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($genres as $g)
            <article
                class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col p-4 cursor-pointer group"
                itemscope itemtype="https://schema.org/CategoryCodeSet">

                <a href="{{ route('genre.show', $g['slug']) }}" class="flex-1 flex flex-col">
                    <div
                        class="aspect-[3/2] w-full bg-neutral-100 rounded-lg flex items-center justify-center mb-3 group-hover:bg-neutral-200 transition">
                        <span class="text-4xl">{{ $g['icon'] }}</span>
                    </div>

                    <h2 class="font-medium text-sm sm:text-base line-clamp-2 text-center group-hover:text-accent transition"
                        itemprop="name">
                        {{ $g['name'] }}
                    </h2>
                </a>
            </article>
        @endforeach
    </div>
</section>
