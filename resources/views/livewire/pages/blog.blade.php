<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">{{ __('blog.title') }}</h1>

    @if (count($posts) === 0)
        <p class="text-neutral-600">{{ __('blog.empty') }}</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                <article
                    class="bg-background rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">
                    <a wire:navigate href="{{ route('blog.show', $post['slug']) }}">
                        <img src="{{ $post['cover'] }}" alt="{{ $post['title'] }}" class="w-full h-40 object-cover"
                            loading="lazy">
                    </a>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-text text-base sm:text-lg mb-1">
                            <a wire:navigate href="{{ route('blog.show', $post['slug']) }}"
                                class="hover:text-accent transition">
                                {{ $post['title'] }}
                            </a>
                        </h3>

                        <p class="text-sm text-secondary line-clamp-2 mb-3">
                            {{ $post['excerpt'] }}
                        </p>

                        <p class="text-xs text-gray-500 mb-4">
                            {{ __('blog.by', ['author' => $post['author']]) }}
                            — {{ __('blog.date', ['date' => \Carbon\Carbon::parse($post['date'])->format('d.m.Y')]) }}
                        </p>

                        <div class="mt-auto pt-3">
                            <a wire:navigate href="{{ route('blog.show', $post['slug']) }}"
                                class="inline-block w-full text-center px-4 py-2 text-sm font-medium text-text border border-accent rounded-lg hover:bg-accent/10 hover:text-text transition"
                                aria-label="{{ __('blog.read_more_aria', ['title' => $post['title']]) }}">
                                {{ __('blog.read_more') }}
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $paginator->links() }}
        </div>
    @endif
</section>
