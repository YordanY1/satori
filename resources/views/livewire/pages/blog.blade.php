<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">{{ __('blog.title') }}</h1>

    @if (count($posts) === 0)
        <p class="text-neutral-600">{{ __('blog.empty') }}</p>
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

                        <p class="text-gray-600 text-sm">
                            {{ $post['excerpt'] }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ __('blog.by', ['author' => $post['author']]) }}
                            — {{ __('blog.date', ['date' => \Carbon\Carbon::parse($post['date'])->format('d.m.Y')]) }}
                        </p>
                    </div>

                    <a wire:navigate href="{{ route('blog.show', $post['slug']) }}"
                        class="mt-auto inline-block w-full text-center px-4 py-2 text-sm font-medium text-text border border-accent rounded-lg hover:bg-accent/10 hover:text-text transition"
                        aria-label="{{ __('blog.read_more_aria', ['title' => $post['title']]) }}">
                        {{ __('blog.read_more') }}
                    </a>

                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $paginator->links() }}
        </div>
    @endif
</section>
