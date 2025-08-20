<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Сатори Ко')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

{{-- Toasts --}}
<div x-data="{
    show: false,
    text: '',
    open(msg) {
        this.text = msg;
        this.show = true;
        setTimeout(() => this.show = false, 2000);
    }
}" @notify.window="open($event.detail.message)" class="fixed bottom-6 right-6 z-[9999]"
    aria-live="polite" aria-atomic="true">
    <div x-show="show" x-transition.duration.200ms
        class="rounded-xl border border-black bg-white text-black shadow-xl px-4 py-2 text-sm font-medium">
        <span x-text="text"></span>
    </div>
</div>

<x-cookie-consent />


<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    window.onRecaptchaSuccess = function(token) {
        const el = document.querySelector('#contact-form');
        if (!el) return;

        const id = el.getAttribute('wire:id');
        const component = Livewire.find(id);

        if (component) {
            component.set('recaptchaToken', token);
        }
    };
</script>

<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <x-header />

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <x-footer />

    @livewire('faq.widget')


    @livewireScripts
</body>

</html>
