<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

    <p class="text-gray-500 text-sm mb-6">
        {{ __('blog.by', ['author' => $post->author ?? __('blog.unknown_author')]) }}
        — {{ __('blog.date', ['date' => $post->created_at?->format('d.m.Y')]) }}
    </p>

    @if ($post->cover)
        @php
            $cover = Str::startsWith($post->cover, ['http://', 'https://'])
                ? $post->cover
                : asset('storage/' . ltrim($post->cover, '/'));
        @endphp

        <img src="{{ $cover }}" alt="{{ $post->title }}" class="w-full rounded-lg mb-6">
    @endif

    <article class="prose prose-lg max-w-none">
        {!! $post->content !!}
    </article>

</section>
