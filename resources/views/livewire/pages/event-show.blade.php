<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl sm:text-3xl font-bold mb-3">{{ $event['title'] }}</h1>

    <p class="text-sm text-gray-600 mb-4">
        📅 {{ \Carbon\Carbon::parse($event['date'])->format('d.m.Y') }}
        — 🕒 {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }}
        @if (!empty($event['location']))
            — 📍 {{ $event['location'] }}
        @endif
    </p>

    @if (!empty($event['cover']))
        <img src="{{ $event['cover'] }}" alt="Корица: {{ $event['title'] }}" class="w-full h-auto rounded-2xl shadow mb-6">
    @endif

    <div class="flex flex-wrap gap-3 mb-6">
        @if (!empty($event['registration_link']))
            <a href="{{ $event['registration_link'] }}" target="_blank" rel="noopener"
                class="px-4 py-2 rounded-lg border border-black bg-white text-black font-semibold hover:bg-gray-100">
                Регистрирай се
            </a>
        @endif

        @if (!empty($event['is_paid']) && !empty($event['payment_link']))
            <a href="{{ $event['payment_link'] }}" target="_blank" rel="noopener"
                class="px-4 py-2 rounded-lg border border-black bg-white text-black font-semibold hover:bg-gray-100">
                Плати/Дари
            </a>
        @endif
    </div>

    @if (!empty($event['program']))
        <h2 class="text-xl font-semibold mb-2">Програма</h2>
        <div class="bg-white rounded-xl p-4 shadow-sm whitespace-pre-line">
            {{ $event['program'] }}
        </div>
    @endif

    @if (!empty($event['video_url']))
        <h2 class="text-xl font-semibold mt-6 mb-2">Видео</h2>
        <div class="aspect-video rounded-xl overflow-hidden shadow">
            <iframe class="w-full h-full" src="{{ $event['video_url'] }}?rel=0&modestbranding=1"
                title="Видео към {{ $event['title'] }}" loading="lazy"
                allow="accelerometer; autoplay; encrypted-media; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
    @endif
</section>
