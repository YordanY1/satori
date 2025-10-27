<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Dynamic SEO Meta --}}
    <title>{{ $seo['title'] ?? 'Издателство Сатори' }}</title>
    <meta name="description"
        content="{{ $seo['description'] ?? 'Открий книги, събития и вдъхновение със Издателство Сатори.' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? 'сатори, книги, издателство, осъзнатост, събития' }}">
    <meta name="author" content="Издателство Сатори">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">
    <meta name="robots" content="index, follow">

    {{-- Language & hreflang --}}
    <meta name="language" content="{{ app()->getLocale() }}">
    <link rel="alternate" hreflang="bg" href="{{ url('/') }}">
    <link rel="alternate" hreflang="en" href="{{ url('/en') }}">

    {{-- Open Graph --}}
    <meta property="og:site_name" content="Издателство Сатори" />
    <meta property="og:title" content="{{ $seo['og:title'] ?? ($seo['title'] ?? 'Издателство Сатори') }}" />
    <meta property="og:description"
        content="{{ $seo['og:description'] ?? ($seo['description'] ?? 'Открий книги и събития от Издателство Сатори.') }}" />
    <meta property="og:image" content="{{ asset('images/logo.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:url" content="{{ $seo['og:url'] ?? url()->current() }}" />
    <meta property="og:type" content="{{ $seo['og:type'] ?? 'website' }}" />
    <meta property="og:locale" content="bg_BG" />

    {{-- Twitter / Viber preview --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $seo['twitter:title'] ?? ($seo['title'] ?? 'Издателство Сатори') }}" />
    <meta name="twitter:description"
        content="{{ $seo['twitter:description'] ?? ($seo['description'] ?? 'Открий книги и събития от Издателство Сатори.') }}" />
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}" />

    {{-- Structured Data: Dynamic Page Schema --}}
    @if (!empty($seo['schema']))
        <script type="application/ld+json">
            {!! json_encode($seo['schema'], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
        </script>
    @endif

    {{-- Structured Data: Organization --}}
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => 'Издателство Сатори',
    'url' => url('/'),
    'logo' => asset('images/logo.png'),
    'sameAs' => [
        'https://www.facebook.com/VBelenski',
    ],
    'contactPoint' => [
        [
            '@type' => 'ContactPoint',
            'contactType' => 'Customer Support',
            'telephone' => '+359 87 849 0782',
            'email' => 'satorico@abv.bg',
            'areaServed' => 'BG',
            'availableLanguage' => ['Bulgarian', 'English'],
        ],
    ],
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => 'ж.к. Овча Купел 1, бл. 411, магазин 2',
        'addressLocality' => 'София',
        'postalCode' => '1632',
        'addressCountry' => 'BG',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>


    {{-- Structured Data: Website --}}
    <script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'url' => url('/'),
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => url('/search') . '?q={search_term_string}',
        'query-input' => 'required name=search_term_string',
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>


    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Performance --}}
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://www.google.com">
    <link rel="dns-prefetch" href="https://www.gstatic.com">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <x-header />

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <x-footer />

    {{-- FAQ Widget + Cookie Consent --}}
    @livewire('faq.widget')
    <x-cookie-consent />

    {{-- Notification Toast --}}
    <div x-data="{
        show: false,
        text: '',
        open(msg) {
            this.text = msg;
            this.show = true;
            setTimeout(() => this.show = false, 2000)
        }
    }" @notify.window="open($event.detail.message)" class="fixed bottom-6 right-6 z-[9999]"
        aria-live="polite" aria-atomic="true">
        <div x-show="show" x-transition.duration.200ms
            class="rounded-xl border border-black bg-white text-black shadow-xl px-4 py-2 text-sm font-medium">
            <span x-text="text"></span>
        </div>
    </div>

    @livewireScripts

    {{-- reCAPTCHA --}}
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
