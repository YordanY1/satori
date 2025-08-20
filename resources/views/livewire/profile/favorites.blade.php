<section class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-extrabold tracking-tight mb-6">Любими продукти</h1>

    @if ($books->isEmpty())
        <p class="text-neutral-600">Още нямаш любими. Разгледай каталога и добавяй с ❤️</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach ($books as $book)
                <article class="rounded-2xl border bg-white shadow-sm overflow-hidden">
                    <a wire:navigate href="{{ route('book.show', $book->slug) }}" class="block">
                        <img src="{{ asset($book->cover) }}" alt="{{ $book->title }}" class="w-full h-40 object-cover">
                        <div class="p-3">
                            <h3 class="font-semibold line-clamp-2">{{ $book->title }}</h3>
                            @isset($book->author)
                                <p class="text-sm text-neutral-600 mt-0.5">{{ $book->author->name }}</p>
                            @endisset
                            <div class="mt-2 flex items-center justify-between">
                                <span class="font-bold">{{ number_format($book->price, 2) }} лв.</span>
                                <span class="text-xs text-neutral-600">❤️ {{ $book->favorited_by_count }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="p-3 pt-0">
                        <livewire:favorite-button :book-id="$book->id" />
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $books->links() }}
        </div>
    @endif
</section>
