<section class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center my-8" itemscope itemtype="https://schema.org/Book">

    <img src="{{ asset($book['cover']) }}" alt="Корица на книгата {{ $book['title'] }}"
        class="rounded-2xl shadow-lg w-full h-auto" loading="lazy" itemprop="image">

    <div>
        <h2 class="text-xl sm:text-2xl font-semibold mb-2 text-primary">
            Книга на месеца
        </h2>

        <h3 class="text-lg sm:text-xl font-medium text-text" itemprop="name">
            {{ $book['title'] }}
        </h3>

        <p class="mt-2 text-neutral-700 leading-relaxed" itemprop="description">
            {{ $book['description'] }}
        </p>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <livewire:cart.add-button :book-id="$book['id']" :book-title="$book['title']" :price="$book['price']" />

            <a href="{{ asset($book['excerpt_url']) }}" class="text-sm text-secondary hover:underline transition"
                aria-label="Прочети откъс от {{ $book['title'] }}">
                📄 Прочети откъс (PDF)
            </a>
        </div>
    </div>
</section>
