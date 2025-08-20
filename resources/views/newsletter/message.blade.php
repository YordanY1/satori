<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('mail.default_title') }} — {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <main class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h1 class="text-2xl font-semibold mb-3">{{ $title ?? __('mail.default_title') }}</h1>

            @if (!empty($body))
                <p class="text-neutral-700 mb-6">{{ $body }}</p>
            @endif

            @isset($excerpt_url)
                <a href="{{ $excerpt_url }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-sky-600 text-sky-700 hover:bg-sky-50 transition">
                    {{ __('mail.download_excerpt') }}
                </a>
            @endisset

            @isset($unsubscribe_url)
                <p class="mt-4 text-sm text-neutral-500">
                    {{ __('mail.unsubscribe_text') }}
                    <a class="underline text-sky-700" href="{{ $unsubscribe_url }}">{{ __('mail.unsubscribe_link') }}</a>.
                </p>
            @endisset
        </div>
    </main>
</body>

</html>
