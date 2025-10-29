<section class="max-w-4xl mx-auto py-10 px-4 space-y-6">
    <h1 class="text-3xl font-bold">{{ __('privacy.title') }}</h1>

    @foreach (__('privacy.sections') as $section)
        <div>
            <h2 class="text-xl font-semibold mt-6 mb-2">{{ $section['title'] }}</h2>
            <p class="whitespace-pre-line leading-relaxed text-gray-700">
                {{ $section['content'] }}
            </p>
        </div>
    @endforeach
</section>
