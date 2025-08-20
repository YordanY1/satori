<section class="max-w-4xl mx-auto px-4 py-12">
    <!-- Title -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Политика за бисквитки</h1>
        <div class="mt-2 inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs">
            <span class="font-medium">Последна актуализация:</span>
            <time class="tabular-nums">{{ now()->format('d.m.Y') }}</time>
        </div>
        <p class="mt-4 text-neutral-700">
            Тази страница обяснява какви бисквитки използваме, защо и как можеш да управляваш съгласието си.
        </p>
    </header>

    <!-- What are cookies -->
    <section class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Какво са бисквитки</h2>
        <p class="mt-2 text-neutral-700">
            Бисквитките са малки текстови файлове, които се запазват на твоето устройство. Има
            <span class="font-medium">сесийни</span> (изтриват се при затваряне на браузъра) и
            <span class="font-medium">постоянни</span> (с конкретен срок на валидност).
        </p>
    </section>

    <!-- Categories -->
    <section class="mt-8">
        <h2 class="text-xl font-semibold">Какви бисквитки използваме</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <article class="rounded-2xl border p-5 bg-white shadow-sm">
                <div class="mb-2 inline-flex items-center gap-2 rounded-full border px-2.5 py-1 text-xs font-semibold">
                    Необходими
                </div>
                <p class="text-neutral-700">
                    Задължителни за сигурност, вход и кошница. Не изискват съгласие.
                </p>
            </article>

            <article class="rounded-2xl border p-5 bg-white shadow-sm">
                <div class="mb-2 inline-flex items-center gap-2 rounded-full border px-2.5 py-1 text-xs font-semibold">
                    Аналитични
                </div>
                <p class="text-neutral-700">
                    Помагат ни да разберем как се използва сайтът (напр. Google Analytics/Matomo).
                    Задават се само след съгласие.
                </p>
            </article>

            <article class="rounded-2xl border p-5 bg-white shadow-sm">
                <div class="mb-2 inline-flex items-center gap-2 rounded-full border px-2.5 py-1 text-xs font-semibold">
                    Маркетингови
                </div>
                <p class="text-neutral-700">
                    За персонализирани реклами и ретаргетинг (напр. Meta Pixel). Задават се само след съгласие.
                </p>
            </article>
        </div>
    </section>

    <!-- Consent management -->
    <section class="mt-8 rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Управление на съгласието</h2>
        <p class="mt-2 text-neutral-700">
            Можеш да промениш избора си по всяко време чрез бутона
            <button @click="$dispatch('cookie:open')"
                class="underline decoration-dotted underline-offset-4 hover:text-black">
                Cookie настройки
            </button>
            във футъра. Аналитични и маркетингови бисквитки се зареждат единствено при дадено съгласие.
        </p>
    </section>

    <!-- Table -->
    <section class="mt-10">
        <h2 class="text-xl font-semibold mb-3">Списък с бисквитки</h2>
        <div class="rounded-2xl border bg-white shadow-sm overflow-hidden">
            <div class="max-h-[520px] overflow-auto">
                <table class="w-full text-left">
                    <thead class="sticky top-0 bg-neutral-50 text-sm">
                        <tr class="border-b">
                            <th class="px-4 py-3 font-semibold">Име</th>
                            <th class="px-4 py-3 font-semibold">Категория</th>
                            <th class="px-4 py-3 font-semibold">Цел</th>
                            <th class="px-4 py-3 font-semibold">Срок</th>
                            <th class="px-4 py-3 font-semibold">Доставчик</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                    
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">XSRF-TOKEN</td>
                            <td class="px-4 py-3">Необходими</td>
                            <td class="px-4 py-3">CSRF защита при форми/заявки</td>
                            <td class="px-4 py-3">Сесия</td>
                            <td class="px-4 py-3">Първа страна</td>
                        </tr>
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">laravel_session</td>
                            <td class="px-4 py-3">Необходими</td>
                            <td class="px-4 py-3">Сесия/аутентикация</td>
                            <td class="px-4 py-3">Сесия</td>
                            <td class="px-4 py-3">Първа страна</td>
                        </tr>
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">cookie_prefs_v1</td>
                            <td class="px-4 py-3">Необходими</td>
                            <td class="px-4 py-3">Запазва избора за consent</td>
                            <td class="px-4 py-3">12 месеца</td>
                            <td class="px-4 py-3">Първа страна</td>
                        </tr>


                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">_ga</td>
                            <td class="px-4 py-3">Аналитични</td>
                            <td class="px-4 py-3">Идентификатор за Google Analytics</td>
                            <td class="px-4 py-3">13 месеца*</td>
                            <td class="px-4 py-3">Google</td>
                        </tr>
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">_ga_XXXXXXXX</td>
                            <td class="px-4 py-3">Аналитични</td>
                            <td class="px-4 py-3">Поддържа сесии за GA4 property</td>
                            <td class="px-4 py-3">13 месеца*</td>
                            <td class="px-4 py-3">Google</td>
                        </tr>
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">_gid</td>
                            <td class="px-4 py-3">Аналитични</td>
                            <td class="px-4 py-3">Различава потребители за 24ч</td>
                            <td class="px-4 py-3">24 часа*</td>
                            <td class="px-4 py-3">Google</td>
                        </tr>


                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">_fbp</td>
                            <td class="px-4 py-3">Маркетингови</td>
                            <td class="px-4 py-3">Рекламен идентификатор (Meta/Facebook)</td>
                            <td class="px-4 py-3">3 месеца*</td>
                            <td class="px-4 py-3">Meta</td>
                        </tr>
                        <tr class="border-b last:border-0">
                            <td class="px-4 py-3 font-mono">_fbc</td>
                            <td class="px-4 py-3">Маркетингови</td>
                            <td class="px-4 py-3">Проследяване на кампании (Meta)</td>
                            <td class="px-4 py-3">3 месеца*</td>
                            <td class="px-4 py-3">Meta</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="border-t bg-neutral-50 px-4 py-3 text-xs text-neutral-600">
                * Точният срок може да варира според настройките на доставчика и/или локалното законодателство.
            </div>
        </div>
    </section>

    <!-- Footer note -->
    <p class="mt-6 text-sm text-neutral-600">
        Забележка: Аналитични и маркетингови бисквитки се създават само ако си дал/а съгласие в „Cookie настройки“.
    </p>
</section>
