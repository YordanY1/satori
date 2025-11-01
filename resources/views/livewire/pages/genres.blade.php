<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" aria-labelledby="genres-title">
    <div class="text-center mb-10">
        <h1 id="genres-title" class="text-3xl sm:text-4xl font-bold">
            {{ __('genres.title') }}
        </h1>
        <p class="text-neutral-700 mt-2 text-lg">
            {{ __('genres.subtitle') }}
        </p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach ($genres as $g)
            <a href="{{ route('genre.show', $g['slug']) }}"
                class="block rounded-2xl border border-neutral-300 bg-neutral-50 shadow-sm p-6">

                {{-- Corners --}}
                <div class="relative">
                    <div class="absolute -top-1 -left-1 w-8 h-8 border-t-2 border-l-2 border-neutral-400 rounded-tl-xl">
                    </div>
                    <div
                        class="absolute -bottom-1 -right-1 w-8 h-8 border-b-2 border-r-2 border-neutral-400 rounded-br-xl">
                    </div>

                    {{-- Title --}}
                    <h2 class="text-center font-serif font-bold text-base sm:text-lg text-neutral-900">
                        {{ $g['name'] }}
                    </h2>

                </div>
            </a>
        @endforeach
    </div>
</section>
