<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Dynamic SEO meta --}}
    <title>{{ $seo['title'] ?? 'Сатори Ко' }}</title>
    <meta name="description" content="{{ $seo['description'] ?? 'Открий книги, събития и вдъхновение със Сатори.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'сатори, книги, събития, осъзнатост' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
    <meta name="robots" content="index, follow">

    {{-- Language & hreflang --}}
    <meta name="language" content="{{ app()->getLocale() }}">
    <link rel="alternate" hreflang="bg" href="{{ url('/') }}">
    <link rel="alternate" hreflang="en" href="{{ url('/en') }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="Сатори Ко" />
    <meta property="og:title" content="{{ $seo['og:title'] ?? ($seo['title'] ?? 'Сатори Ко') }}" />
    <meta property="og:description"
        content="{{ $seo['og:description'] ?? ($seo['description'] ?? 'Открий книги и събития.') }}" />
    <meta property="og:image" content="{{ $seo['og:image'] ?? asset('images/default-og.jpg') }}" />
    <meta property="og:url" content="{{ $seo['og:url'] ?? url()->current() }}" />
    <meta property="og:type" content="{{ $seo['og:type'] ?? 'website' }}" />

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $seo['twitter:title'] ?? ($seo['title'] ?? 'Сатори Ко') }}" />
    <meta name="twitter:description"
        content="{{ $seo['twitter:description'] ?? ($seo['description'] ?? 'Открий книги и събития.') }}" />
    <meta name="twitter:image" content="{{ $seo['twitter:image'] ?? asset('images/default-og.jpg') }}" />

    {{-- Structured Data --}}
    @if (!empty($seo['schema']))
        <script type="application/ld+json">
            {!! json_encode($seo['schema'], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
        </script>
    @endif

    {{--  Favicons --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <x-header />

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <x-footer />
    @livewire('faq.widget')
    <x-cookie-consent />

    {{--  Notification Toast --}}
    <div x-data="{ show: false, text: '', open(msg) { this.text = msg;
            this.show = true;
            setTimeout(() => this.show = false, 2000) } }" @notify.window="open($event.detail.message)" class="fixed bottom-6 right-6 z-[9999]"
        aria-live="polite" aria-atomic="true">
        <div x-show="show" x-transition.duration.200ms
            class="rounded-xl border border-black bg-white text-black shadow-xl px-4 py-2 text-sm font-medium">
            <span x-text="text"></span>
        </div>
    </div>

    @livewireScripts
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        window.onRecaptchaSuccess = function(token) {
            const el = document.querySelector('#contact-form');
            if (!el) return;
            const id = el.getAttribute('wire:id');
            const component = Livewire.find(id);
            if (component) component.set('recaptchaToken', token);
        };
    </script>
</body>

</html>
