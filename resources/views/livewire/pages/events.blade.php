<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Събития</h1>

    <div class="grid gap-6 md:grid-cols-2">
        @foreach ($events as $event)
            <article
                class="border rounded-xl shadow-sm hover:shadow-md transition bg-white p-4 flex flex-col justify-between">
                {{-- Корица (ако има) --}}
                <a wire:navigate href="{{ route('event.show', $event['slug']) }}" class="block">
                    @if (!empty($event['cover']))
                        <img src="{{ $event['cover'] }}" alt="Корица на събитието: {{ $event['title'] }}" loading="lazy"
                            class="w-full h-40 sm:h-48 object-cover rounded-lg mb-3">
                    @else
                        <div
                            class="w-full h-40 sm:h-48 rounded-lg mb-3 bg-neutral-100 grid place-items-center text-neutral-400">
                            Няма корица
                        </div>
                    @endif
                </a>

                <div>
                    <h2 class="text-xl font-semibold mb-2">
                        <a wire:navigate href="{{ route('event.show', $event['slug']) }}">
                            {{ $event['title'] }}
                        </a>
                    </h2>

                    <p class="text-sm text-gray-600 mb-1">
                        📅 {{ \Carbon\Carbon::parse($event['date'])->format('d.m.Y') }} —
                        🕒 {{ \Carbon\Carbon::parse($event['date'])->format('H:i') }}
                    </p>

                    @if (!empty($event['location']))
                        <p class="text-sm text-gray-600">📍 {{ $event['location'] }}</p>
                    @endif
                </div>

                <a wire:navigate href="{{ route('event.show', $event['slug']) }}"
                    class="mt-4 px-4 py-2 rounded-lg border border-black bg-white text-black font-semibold hover:bg-accent hover:text-black transition text-center">
                    Виж повече
                </a>
            </article>
        @endforeach
    </div>
</section>
