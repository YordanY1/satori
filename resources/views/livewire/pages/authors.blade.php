@php use Illuminate\Support\Str; @endphp

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" aria-labelledby="authors-title">
    <h1 id="authors-title" class="text-3xl font-bold mb-6">Автори</h1>

    <p class="text-neutral-700 mb-6">Писатели, философи и преводачи, които вдъхновяват.</p>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach ($authors as $a)
            @php
                $photo = $a->photo
                    ? (Str::startsWith($a->photo, ['http://', 'https://'])
                        ? $a->photo
                        : asset($a->photo))
                    : asset('storage/authors/default.jpg');
            @endphp

            <article class="bg-white rounded-2xl p-3 shadow-sm hover:shadow-md transition text-center" itemscope
                itemtype="https://schema.org/Person">
                <a href="{{ route('author.show', $a->slug) }}" aria-label="Виж {{ $a->name }}">
                    <img src="{{ $photo }}" alt="Снимка на {{ $a->name }}"
                        class="w-full h-40 object-cover rounded-xl mb-3" loading="lazy" itemprop="image">
                </a>
                <h2 class="font-semibold text-sm sm:text-base" itemprop="name">
                    <a href="{{ route('author.show', $a->slug) }}" class="hover:text-accent transition">
                        {{ $a->name }}
                    </a>
                </h2>
            </article>
        @endforeach
    </div>
</section>
