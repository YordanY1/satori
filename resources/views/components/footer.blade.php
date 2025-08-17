<footer class="mt-16 border-t bg-white text-black" role="contentinfo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 text-sm">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-8">

            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-3 group" aria-label="Начало – Сатори Ко">
                    <img src="{{ asset('logo.svg') }}" alt="Satori – Онлайн книжарница" class="h-10 w-10">
                    <span class="font-bold tracking-wide text-black group-hover:text-accent transition-colors text-lg">
                        Сатори Ко
                    </span>
                </a>
                <p class="leading-relaxed text-neutral-700">
                    Издателска платформа за осъзнат живот. Открий книги, събития и идеи, които вдъхновяват.
                </p>
            </div>

            <div>
                <p class="font-semibold mb-3 text-accent">Навигация</p>
                <ul class="space-y-1">
                    @foreach ([['route' => 'catalog', 'label' => 'Книги'], ['route' => 'authors', 'label' => 'Автори'], ['route' => 'events', 'label' => 'Събития'], ['route' => 'blog', 'label' => 'Блог'], ['route' => 'about', 'label' => 'За нас'], ['route' => 'contact', 'label' => 'Контакти']] as $item)
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="relative text-neutral-800 transition-colors hover:text-black after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:w-0 after:h-[2px] after:bg-black after:transition-all after:duration-300 hover:after:w-full">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="font-semibold mb-3 text-accent">Абонамент за новини</p>
                <p class="mb-3 text-neutral-700">Получавайте първи новини за нови книги, събития и промоции.</p>
                <livewire:newsletter.signup />
            </div>
        </div>

        <div
            class="mt-8 pt-6 border-t border-neutral-200 text-xs text-neutral-500 flex flex-col sm:flex-row justify-between items-center gap-2">
            <span>© {{ date('Y') }} Сатори Ко. Всички права запазени.</span>
            <span>Създадено с ❤️ в България</span>
        </div>
    </div>
</footer>
