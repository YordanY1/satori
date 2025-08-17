<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Блог / Статии</h1>

    @if (count($posts) === 0)
        <p class="text-neutral-600">Няма публикувани статии (още).</p>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <article class="border rounded-xl shadow-sm hover:shadow-md transition bg-white flex flex-col">
                    <a wire:navigate href="{{ route('blog.show', $post['slug']) }}">
                        <img src="{{ $post['cover'] }}" alt="{{ $post['title'] }}"
                            class="w-full h-48 object-cover rounded-t-xl" loading="lazy">
                    </a>

                    <div class="p-4 flex flex-col gap-2 flex-grow">
                        <h2 class="text-xl font-semibold">
                            <a wire:navigate href="{{ route('blog.show', $post['slug']) }}">
                                {{ $post['title'] }}
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm">{{ $post['excerpt'] }}</p>
                        <p class="text-xs text-gray-500">
                            ✍ {{ $post['author'] }} — 📅 {{ \Carbon\Carbon::parse($post['date'])->format('d.m.Y') }}
                        </p>
                    </div>

                    <a wire:navigate href="{{ route('blog.show', $post['slug']) }}"
                        class="mt-auto px-4 py-2 rounded-lg bg-accent text-black font-semibold hover:bg-accent/90 transition text-center">
                        Прочети повече
                    </a>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $paginator->links() }}
        </div>
    @endif
</section>
