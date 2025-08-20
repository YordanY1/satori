<div x-data="{ open: @entangle('open') }" class="fixed bottom-6 right-6 z-[9998]">
    {{-- FAB button --}}
    <button @click="open = !open"
        class="rounded-full bg-black text-white w-14 h-14 grid place-items-center shadow-lg shadow-black/20 hover:bg-black/90 focus:ring-4 focus:ring-black/20">
        ❓
    </button>

    {{-- Panel --}}
    <div x-show="open" x-cloak x-transition.origin.bottom.right
        class="mt-3 w-80 sm:w-96 rounded-2xl border bg-white shadow-2xl overflow-hidden">

        <div class="border-b px-4 py-3 flex items-center justify-between">
            <div class="font-semibold">Помощ</div>
            <button class="text-neutral-500 hover:text-black" @click="open=false">✖</button>
        </div>

        <div class="p-4 space-y-4">
            {{-- Search --}}
            <div>
                <label class="sr-only">Търси</label>
                <input type="search" wire:model.live.debounce.250ms="q" placeholder="Какво търсиш?"
                    class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-black/10">
            </div>

            {{-- Results / Suggestions --}}
            <div class="space-y-3 max-h-56 overflow-auto">
                @forelse($results as $r)
                    <article class="rounded-xl border p-3 hover:bg-neutral-50">
                        <h3 class="font-medium text-sm">{{ $r['question'] }}</h3>
                        <p class="text-sm text-neutral-700 mt-1">{{ $r['answer'] }}</p>
                    </article>
                @empty
                    <p class="text-sm text-neutral-500">Няма резултати. Опитай с друга дума.</p>
                @endforelse
            </div>

            {{-- Quick suggestions (click to fill) --}}
            @if (!empty($suggested))
                <div class="text-xs text-neutral-500">Популярни:</div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($suggested as $s)
                        <button wire:click="fillFromSuggestion({{ $s['id'] }})"
                            class="rounded-full border px-3 py-1 text-xs hover:bg-neutral-50">
                            {{ $s['question'] }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Divider --}}
            <hr>

            {{-- Quick contact --}}
            {{-- <div class="space-y-2">
                <div class="text-sm font-medium">Не намери отговор?</div>
                <input type="text" wire:model.lazy="contact_name" placeholder="Име"
                    class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-black/10">
                @error('contact_name')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <input type="email" wire:model.lazy="contact_email" placeholder="Имейл"
                    class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-black/10">
                @error('contact_email')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <textarea wire:model.lazy="contact_message" placeholder="Въпросът ти..."
                    class="w-full rounded-xl border px-3 py-2 text-sm focus:outline-none focus:ring-4 focus:ring-black/10"
                    rows="3"></textarea>
                @error('contact_message')
                    <p class="text-xs text-red-600">{{ $message }}</p>
                @enderror

                <button wire:click="quickAsk"
                    class="w-full rounded-xl bg-black text-white py-2 text-sm font-semibold hover:bg-black/90 focus:ring-4 focus:ring-black/20">
                    Изпрати
                </button>
            </div> --}}
        </div>
    </div>
</div>
