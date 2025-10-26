<footer class="mt-16 border-t bg-white text-black" role="contentinfo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10 text-sm">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-8">

            {{-- BRAND / ABOUT --}}
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

                {{-- SOCIALS --}}
                <div class="flex gap-3 mt-4 text-2xl">
                    <a href="https://www.facebook.com/VBelenski" target="_blank" rel="noopener" aria-label="Facebook"
                        class="hover:text-accent transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path
                                d="M22 12a10 10 0 1 0-11.5 9.9v-7h-2v-3h2v-2.3c0-2 1.2-3.1 3-3.1.9 0 1.8.1 1.8.1v2h-1c-1 0-1.3.6-1.3 1.2V12h2.3l-.4 3h-1.9v7A10 10 0 0 0 22 12z" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- NAVIGATION --}}
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

            {{-- NEWSLETTER --}}
            <div>
                <p class="font-semibold mb-3 text-accent">{{ __('footer.newsletter') }}</p>
                <p class="mb-3 text-neutral-700">{{ __('footer.newsletter_sub') }}</p>
                <livewire:newsletter.signup />
            </div>
        </div>

        {{-- BOTTOM LINE --}}
        <div
            class="mt-10 border-t border-neutral-200 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-neutral-500">
            <span>{{ __('footer.copyright', ['year' => date('Y')]) }}</span>
            <span>{{ __('footer.made_with') }}</span>
        </div>

        {{-- LEGAL LINKS --}}
        <div class="flex justify-center gap-6 mt-4 text-xs text-neutral-600">
            <a wire:navigate href="{{ route('privacy') }}" class="hover:text-accent">{{ __('footer.privacy') }}</a>
            <a wire:navigate href="{{ route('cookies') }}" class="hover:text-accent">{{ __('footer.cookies') }}</a>
            <a wire:navigate href="{{ route('terms') }}" class="hover:text-accent">{{ __('footer.terms') }}</a>
        </div>
    </div>
</footer>
