@php use Illuminate\Support\Str; @endphp

<section aria-labelledby="media-section" class="my-8">
    <h2 id="media-section" class="text-xl sm:text-2xl font-semibold text-primary mb-4">
        {{ __('media.section_title') }}
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @foreach ($items as $m)
            @if ($m['type'] === 'youtube')
                <article class="bg-background rounded-2xl p-4 shadow-sm hover:shadow-md transition" itemscope
                    itemtype="https://schema.org/VideoObject">

                    <h3 class="font-medium mb-2 text-text" itemprop="name">{{ $m['title'] }}</h3>
                    <meta itemprop="thumbnailUrl" content="https://i.ytimg.com/vi/{{ $m['id'] }}/hqdefault.jpg">
                    <meta itemprop="embedUrl" content="https://www.youtube.com/embed/{{ $m['id'] }}">
                    <meta itemprop="contentUrl" content="https://www.youtube.com/watch?v={{ $m['id'] }}">

                    <figure class="aspect-video rounded-xl overflow-hidden border border-neutral/60">
                        <iframe class="w-full h-full"
                            src="https://www.youtube.com/embed/{{ $m['id'] }}?rel=0&modestbranding=1"
                            title="{{ __('media.yt_iframe', ['title' => $m['title']]) }}" loading="lazy"
                            allow="accelerometer; autoplay; encrypted-media; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </figure>

                    <a href="https://www.youtube.com/watch?v={{ $m['id'] }}"
                        class="mt-3 inline-flex items-center gap-2 text-accent hover:underline" itemprop="url"
                        target="_blank" rel="noopener">
                        {{ __('media.watch_on_yt') }}
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </article>
            @elseif ($m['type'] === 'audio')
                @php
                    $src = Str::startsWith($m['src'], ['http://', 'https://'])
                        ? $m['src']
                        : asset('storage/' . ltrim($m['src'], '/'));
                @endphp

                <article class="bg-background rounded-2xl p-4 shadow-sm hover:shadow-md transition" itemscope
                    itemtype="https://schema.org/AudioObject">

                    <h3 class="font-medium mb-4 text-text text-center" itemprop="name">
                        {{ __('media.audio_title', ['title' => $m['title']]) }}
                    </h3>
                    <meta itemprop="encodingFormat" content="audio/mpeg">
                    <link itemprop="contentUrl" href="{{ $src }}">

                    <div class="flex justify-center mt-4">
                        <audio controls class="w-full max-w-md rounded-lg border border-neutral/30 bg-white p-1"
                            preload="none">
                            <source src="{{ $src }}" type="audio/mpeg">
                        </audio>
                    </div>
                </article>
            @endif
        @endforeach
    </div>
</section>
