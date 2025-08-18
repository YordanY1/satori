<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">{{ __('events.events') }}</h1>

    <div class="grid gap-6 md:grid-cols-2">
        @foreach ($events as $event)
            <article
                class="border rounded-xl shadow-sm hover:shadow-md transition bg-white p-4 flex flex-col justify-between">
                <a wire:navigate href="{{ route('event.show', $event['slug']) }}" class="block">
                    @if (!empty($event['cover']))
                        <img src="{{ $event['cover'] }}"
                            alt="{{ __('events.event_cover', ['title' => $event['title']]) }}" loading="lazy"
                            class="w-full h-40 sm:h-48 object-cover rounded-lg mb-3">
                    @else
                        <div
                            class="w-full h-40 sm:h-48 rounded-lg mb-3 bg-neutral-100 grid place-items-center text-neutral-400">
                            {{ __('events.no_cover') }}
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
                        {{ __('events.date', ['date' => \Carbon\Carbon::parse($event['date'])->format('d.m.Y')]) }}
                        —
                        {{ __('events.time', ['time' => \Carbon\Carbon::parse($event['date'])->format('H:i')]) }}
                    </p>

                    @if (!empty($event['location']))
                        <p class="text-sm text-gray-600">
                            {{ __('events.location', ['location' => $event['location']]) }}
                        </p>
                    @endif
                </div>

                <a wire:navigate href="{{ route('event.show', $event['slug']) }}"
                    class="mt-4 px-4 py-2 rounded-lg border border-black bg-white text-black font-semibold hover:bg-accent hover:text-black transition text-center">
                    {{ __('events.see_more') }}
                </a>
            </article>
        @endforeach
    </div>
</section>
