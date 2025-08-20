<div class="rounded-2xl border bg-white p-4 shadow-sm">
    <h3 class="font-semibold mb-3">Остави ревю</h3>

    <form wire:submit.prevent="submit" class="grid gap-3">
        <div>
            <label class="text-sm font-medium">Име</label>
            <input type="text" wire:model.lazy="name"
                class="mt-1 w-full rounded-xl border px-3 py-2 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Оценка</label>
            <div class="mt-1 flex items-center gap-1">
                @for ($i = 1; $i <= 5; $i++)
                    <button type="button" wire:click="$set('rating', {{ $i }})"
                        class="text-2xl leading-none {{ $rating >= $i ? 'text-yellow-500' : 'text-neutral-300' }}"
                        aria-label="Оценка {{ $i }} от 5">★</button>
                @endfor
            </div>
            @error('rating')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm font-medium">Коментар (по желание)</label>
            <textarea wire:model.lazy="content" rows="4"
                class="mt-1 w-full rounded-xl border px-3 py-2 @error('content') border-red-500 @enderror"
                placeholder="Какво ти хареса/не ти хареса?"></textarea>
            @error('content')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-1">
            <button type="submit"
                class="rounded-xl bg-black text-white font-semibold px-4 py-2
                       hover:bg-neutral-900 focus:outline-none focus:ring-2 focus:ring-black/20"
                wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Изпрати</span>
                <span wire:loading wire:target="submit">Изпращане…</span>
            </button>
        </div>
    </form>
</div>
