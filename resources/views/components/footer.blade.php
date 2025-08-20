<footer class="mt-16 border-t bg-white text-black" role="contentinfo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 text-sm">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-8">

            <div>
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-3 group"
                    aria-label="{{ __('footer.brand_aria') }}">
                    <img src="{{ asset('logo.svg') }}" alt="{{ __('footer.brand_alt') }}" class="h-10 w-10">
                    <span class="font-bold tracking-wide text-black group-hover:text-accent transition-colors text-lg">
                        {{ __('footer.brand_full') }}
                    </span>
                </a>
                <p class="leading-relaxed text-neutral-700">
                    {{ __('footer.description') }}
                </p>
            </div>

            <div>
                <p class="font-semibold mb-3 text-accent">{{ __('footer.navigation') }}</p>
                <ul class="space-y-1">
                    @php
                        $menu = [
                            ['route' => 'catalog', 'label' => __('footer.menu.catalog')],
                            ['route' => 'authors', 'label' => __('footer.menu.authors')],
                            ['route' => 'events', 'label' => __('footer.menu.events')],
                            ['route' => 'blog', 'label' => __('footer.menu.blog')],
                            ['route' => 'about', 'label' => __('footer.menu.about')],
                            ['route' => 'contact', 'label' => __('footer.menu.contact')],
                        ];
                    @endphp
                    @foreach ($menu as $item)
                        <li>
                            <a href="{{ route($item['route']) }}"
                                class="relative text-neutral-800 transition-colors hover:text-black
                                      after:content-[''] after:absolute after:left-0 after:-bottom-0.5 after:w-0
                                      after:h-[2px] after:bg-black after:transition-all after:duration-300
                                      hover:after:w-full">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <p class="font-semibold mb-3 text-accent">{{ __('footer.newsletter') }}</p>
                <p class="mb-3 text-neutral-700">{{ __('footer.newsletter_sub') }}</p>
                <livewire:newsletter.signup />
            </div>
        </div>

        <div
            class="mt-8 pt-6 border-t border-neutral-200 text-xs text-neutral-500 flex flex-col sm:flex-row justify-between items-center gap-2">
            <span>{{ __('footer.copyright', ['year' => date('Y')]) }}</span>
            <span>{{ __('footer.made_with') }}</span>
        </div>

        <div class="flex justify-center gap-6">
            <a wire:navigate href="{{ route('privacy') }}">Политика за поверителност</a>
            <a wire:navigate href="{{ route('cookies') }}">Политика за бисквитки</a>
            <a wire:navigate href="{{ route('terms') }}">Общи условия</a>
            {{-- <button @click="$dispatch('cookie:open')" class="underline">Cookie настройки</button> --}}
        </div>
    </div>
</footer>
