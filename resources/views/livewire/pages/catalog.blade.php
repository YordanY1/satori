<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="catalog-title">
    <h1 id="catalog-title" class="text-3xl font-bold mb-6">
        Каталог с книги – Онлайн книжарница Сатори Ко
    </h1>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">

            <label class="sr-only" for="filter-author">Филтър по автор</label>
            <select id="filter-author" wire:model.live="filters.author" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="">Всички автори</option>
                @foreach ($authorOptions as $opt)
                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                @endforeach
            </select>


            <label class="sr-only" for="filter-genre">Филтър по жанр</label>
            <select id="filter-genre" wire:model.live="filters.genre" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="">Всички жанрове</option>
                @foreach ($genreOptions as $opt)
                    <option value="{{ $opt->id }}">{{ $opt->name }}</option>
                @endforeach
            </select>


            <label class="sr-only" for="filter-format">Филтър по формат</label>
            <select id="filter-format" wire:model.live="filters.format"
                class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="">Всички формати</option>
                <option value="paper">Хартиена</option>
                <option value="ebook">Електронна</option>
            </select>
        </div>

        <div class="w-full sm:w-auto">
            <label class="sr-only" for="sort-books">Сортиране</label>
            <select id="sort-books" wire:model.live="sort" class="border rounded px-3 py-2 w-full sm:w-auto">
                <option value="popular">По популярност</option>
                <option value="new">Нови</option>
                <option value="price_asc">Цена: Ниска към висока</option>
                <option value="price_desc">Цена: Висока към ниска</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($books as $book)
            <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col" itemscope
                itemtype="https://schema.org/Book">

                <a href="{{ route('book.show', $book['slug'] ?? '') }}"
                    aria-label="Виж детайли за {{ $book['title'] }}">
                    <img src="{{ $book['cover'] }}" alt="Корицата на книгата {{ $book['title'] }}"
                        class="w-full h-40 sm:h-48 object-cover rounded-t-xl" loading="lazy" itemprop="image">
                </a>

                <div class="p-3 flex flex-col gap-2 flex-1">
                    <h2 class="font-medium text-sm sm:text-base line-clamp-2" itemprop="name">
                        {{ $book['title'] }}
                    </h2>
                    <span class="text-accent font-bold" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="BGN">
                        <span itemprop="price">{{ number_format($book['price'], 2) }}</span> лв.
                    </span>
                    <button wire:click="addToCart({{ (int) $book['id'] }})"
                        class="mt-auto rounded-xl bg-white text-black border border-black font-semibold px-3 py-2 text-sm transition cursor-pointer hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-accent/40"
                        aria-label="Добави {{ $book['title'] }} в количката">
                        Добави в количка
                    </button>

                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $booksPaginator->links() }}
    </div>
</section>
