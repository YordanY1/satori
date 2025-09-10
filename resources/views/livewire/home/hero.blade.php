@php use Illuminate\Support\Str; @endphp

<section x-data="{
    rotating: @js($rotateEveryMs > 0),
    interval: null,
    start() {
        if (this.rotating && !this.interval) {
            this.interval = setInterval(() => { $wire.next() }, @js($rotateEveryMs));
        }
    },
    stop() {
        if (this.interval) {
            clearInterval(this.interval);
            this.interval = null;
        }
    },
    handleKey(e) { if (e.key === 'ArrowLeft') $wire.prev(); if (e.key === 'ArrowRight') $wire.next(); }
}" x-init="start();
window.addEventListener('keydown', handleKey);" @mouseenter="stop()" @mouseleave="start()"
    class="relative overflow-hidden rounded-2xl bg-primary text-background h-[300px] sm:h-[460px]"
    aria-label="{{ __('slider.section_aria') }}">

    @if (!empty($slides) && isset($slides[$active]))
        @php $slide = $slides[$active]; @endphp

        <div wire:key="slide-{{ $active }}" class="contents">
            <figure class="absolute inset-0 w-full h-full">
                @php
                    $img = Str::startsWith($slide['image'] ?? '', ['http://', 'https://'])
                        ? $slide['image']
                        : asset($slide['image'] ?? 'storage/images/hero-1.jpg');
                    $alt = $slide['alt'] ?? ($slide['title'] ?? __('slider.slide_fallback'));
                @endphp
                <img src="{{ $img }}" alt="{{ $alt }}" loading="lazy"
                    class="w-full h-full object-cover">
            </figure>

            <div
                class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/70 to-primary/30 pointer-events-none">
            </div>

            <div class="relative z-10 h-full grid place-items-center px-4 sm:px-8">
                <div class="max-w-2xl text-center bg-primary/40 backdrop-blur-md rounded-2xl p-4 sm:p-8 shadow-xl">
                    <h2 class="text-xl sm:text-4xl font-bold leading-tight text-white drop-shadow-lg">
                        {{ $slide['title'] ?? '' }}
                    </h2>

                    @php $subtitle = $slide['subtitle'] ?? ''; @endphp
                    @if (is_string($subtitle) && Str::endsWith(Str::lower($subtitle), '.pdf'))
                        <a href="{{ Str::startsWith($subtitle, ['http://', 'https://']) ? $subtitle : asset($subtitle) }}"
                            class="mt-2 inline-block underline underline-offset-4 text-background/90 text-xs sm:text-base"
                            target="_blank" rel="noopener">
                            {{ __('slider.download_pdf') }}
                        </a>
                    @else
                        <p class="mt-2 text-background/90 text-xs sm:text-base">{{ $subtitle }}</p>
                    @endif

                    @if (!empty($slide['cta']['url'] ?? null) && !empty($slide['cta']['label'] ?? null))
                        <div class="mt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                            <a href="{{ $slide['cta']['url'] }}"
                                class="inline-flex items-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 rounded-xl
                                      bg-accent text-white font-semibold shadow-[0_12px_28px_-8px_rgba(0,0,0,0.5)]
                                      hover:bg-accent/90 transition focus:outline-none focus:ring-4 focus:ring-accent/40"
                                title="{{ $slide['cta']['label'] }}">
                                {{ $slide['cta']['label'] }}
                                <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none"
                                    aria-hidden="true">
                                    <path d="M5 12h14M13 5l7 7-7 7" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <button wire:click="prev"
        class="grid absolute left-3 top-1/2 -translate-y-1/2 h-10 w-10 sm:h-12 sm:w-12 place-items-center rounded-full
               bg-accent text-white border border-accent/20 shadow-lg hover:bg-accent/90 hover:border-accent
               focus:outline-none focus:ring-4 focus:ring-accent/50 transition z-30"
        aria-label="{{ __('slider.prev') }}">‹</button>

    <button wire:click="next"
        class="grid absolute right-3 top-1/2 -translate-y-1/2 h-10 w-10 sm:h-12 sm:w-12 place-items-center rounded-full
               bg-accent text-white border border-accent/20 shadow-lg hover:bg-accent/90 hover:border-accent
               focus:outline-none focus:ring-4 focus:ring-accent/50 transition z-30"
        aria-label="{{ __('slider.next') }}">›</button>

    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 px-4 z-30">
        @foreach ($slides as $i => $_)
            <button wire:key="dot-{{ $i }}" wire:click="goTo({{ $i }})"
                class="h-1.5 rounded-full transition-all duration-300
                       {{ $i === $active ? 'w-8 bg-accent shadow-lg' : 'w-4 bg-background/70 hover:bg-background/90' }}"
                aria-label="{{ __('slider.goto', ['n' => $i + 1]) }}">
            </button>
        @endforeach
    </div>
</section>
