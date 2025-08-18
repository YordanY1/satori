<!DOCTYPE html>
<html lang="bg" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Съобщение' }} — {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-900 antialiased">
    <main class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h1 class="text-2xl font-semibold mb-3">{{ $title ?? 'Съобщение' }}</h1>

            @if (!empty($body))
                <p class="text-neutral-700 mb-6">{{ $body }}</p>
            @endif

            @isset($excerpt_url)
                <a href="{{ $excerpt_url }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-sky-600 text-sky-700 hover:bg-sky-50 transition">
                    Свали откъса (PDF)
                </a>
            @endisset

            @isset($unsubscribe_url)
                <p class="mt-4 text-sm text-neutral-500">
                    Не желаеш повече имейли?
                    <a class="underline text-sky-700" href="{{ $unsubscribe_url }}">Отпиши се</a>.
                </p>
            @endisset
        </div>
    </main>
</body>
</html>
