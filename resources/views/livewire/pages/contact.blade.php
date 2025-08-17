<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold mb-6">Контакти</h1>

    <div class="grid md:grid-cols-2 gap-8">
        <div>
            @if (session('success'))
                <div class="p-4 mb-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form wire:submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="name" class="block font-medium">Име</label>
                    <input type="text" id="name" wire:model="name" class="w-full border rounded px-3 py-2">
                    @error('name')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block font-medium">Имейл</label>
                    <input type="email" id="email" wire:model="email" class="w-full border rounded px-3 py-2">
                    @error('email')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block font-medium">Съобщение</label>
                    <textarea id="message" rows="5" wire:model="message" class="w-full border rounded px-3 py-2"></textarea>
                    @error('message')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="px-5 py-3 rounded-lg bg-accent text-white font-semibold hover:bg-accent/90 transition">
                    Изпрати
                </button>
            </form>
        </div>


        <div class="space-y-4">
            <p>📧 <a href="mailto:info@satori-ko.bg" class="text-accent hover:underline">info@satori-ko.bg</a></p>
            <p>📞 <a href="tel:+359888123456" class="text-accent hover:underline">+359 888 123 456</a></p>
            <p>📍 София, ул. „Примерна“ 42</p>

            <div class="flex gap-3 text-2xl">
                <a href="https://facebook.com" target="_blank" class="hover:text-accent">🌐</a>
                <a href="https://instagram.com" target="_blank" class="hover:text-accent">📸</a>
                <a href="https://youtube.com" target="_blank" class="hover:text-accent">▶️</a>
            </div>


            <div class="mt-6 aspect-video">
                <iframe class="w-full h-full rounded-lg" src="https://www.google.com/maps/embed?pb=!1m18!..."
                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
