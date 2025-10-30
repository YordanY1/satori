@php use Illuminate\Support\Str; @endphp

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="authors-title">
    <h1 id="authors-title" class="text-3xl font-bold mb-6">
        {{ __('authors.title') }}
    </h1>

    <p class="text-neutral-700 mb-6">
        {{ __('authors.subtitle') }}
    </p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach ($authors as $a)
            @php
                $photo = $a->photo
                    ? (Str::startsWith($a->photo, ['http://', 'https://'])
                        ? $a->photo
                        : asset('storage/' . ltrim($a->photo, '/')))
                    : asset('images/avatar.png');
            @endphp

            <article
                class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-md transition text-center flex flex-col min-h-[280px]"
                itemscope itemtype="https://schema.org/Person">

                <figure class="flex flex-col h-full">

                    <a href="{{ route('author.show', $a->slug) }}" itemprop="url">
                        <div class="aspect-[3/4] w-full rounded-xl mb-3 relative overflow-hidden bg-neutral-200">

                            {{-- blurred background filler --}}
                            <img src="{{ $photo }}"
                                class="absolute inset-0 w-full h-full object-cover blur-md scale-110 opacity-60"
                                alt="" aria-hidden="true">

                            {{-- main image --}}
                            <img src="{{ $photo }}" alt="{{ __('authors.alt.photo', ['name' => $a->name]) }}"
                                class="absolute inset-0 w-full h-full object-contain z-10" loading="lazy"
                                itemprop="image">
                        </div>
                    </a>

                    <figcaption class="font-semibold text-sm sm:text-base mt-auto" itemprop="name">
                        <a href="{{ route('author.show', $a->slug) }}" class="hover:text-accent transition">
                            {{ $a->name }}
                        </a>
                    </figcaption>
                </figure>

            </article>
        @endforeach
    </div>
</section>
