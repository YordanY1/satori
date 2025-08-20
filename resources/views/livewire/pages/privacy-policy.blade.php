<section class="max-w-4xl mx-auto px-4 py-12">
    <!-- Header -->
    <header class="mb-8">
        <h1 class="text-3xl font-bold tracking-tight">Политика за поверителност</h1>
        <div class="mt-2 inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs">
            <span class="font-medium">Последна актуализация:</span>
            <time class="tabular-nums">{{ now()->format('d.m.Y') }}</time>
        </div>
        <p class="mt-4 text-neutral-700">
            Тази политика описва как обработваме личните данни в съответствие с GDPR.
        </p>
    </header>

    <!-- Who we are -->
    <section class="rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Кой сме ние</h2>
        <p class="mt-2 text-neutral-700">
            [Фирма/Лице], [ЕИК], [адрес]. Имейл за контакт: <a class="underline"
                href="mailto:privacy@example.com">privacy@example.com</a>. Телефон: [телефон].
        </p>
    </section>

    <!-- What we collect -->
    <section class="mt-8 rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Какви данни събираме</h2>
        <ul class="mt-3 space-y-2 text-neutral-700">
            <li><span class="font-medium">Акаунт:</span> име, имейл, парола (хеширана).</li>
            <li><span class="font-medium">Поръчки:</span> име, имейл, телефон, адрес за доставка/фактура.</li>
            <li><span class="font-medium">Комуникация:</span> съдържание на запитвания през формата за
                контакт/поддръжка.</li>
            <li><span class="font-medium">Cookies:</span> използваме само <em>необходими</em> бисквитки за сигурност,
                вход и кошница (без аналитични/маркетингови по подразбиране). За детайли виж <a class="underline"
                    href="{{ route('cookies') }}">Политика за бисквитки</a>.</li>
        </ul>
        <p class="mt-3 text-neutral-700">
            <strong>Важно:</strong> Не събираме и не съхраняваме IP адреси или user agent за аналитични/маркетингови
            цели.
        </p>
    </section>

    <!-- Legal bases -->
    <section class="mt-8 grid gap-4 sm:grid-cols-2">
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Правно основание</h3>
            <ul class="mt-3 list-disc list-inside text-neutral-700 space-y-1">
                <li>Договор – обработка на поръчки и доставка.</li>
                <li>Съгласие – бюлетин/маркетинг и cookies извън „необходими“.</li>
                <li>Закон – счетоводни и данъчни изисквания.</li>
                <li>Легитимен интерес – сигурност и предотвратяване на злоупотреби.</li>
            </ul>
        </article>
        <article class="rounded-2xl border bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold">Срокове за съхранение</h3>
            <ul class="mt-3 list-disc list-inside text-neutral-700 space-y-1">
                <li>Профилни данни – до закриване на профила.</li>
                <li>Данни за поръчки/фактури – до 5 години (законова задълженост).</li>
                <li>Кореспонденция – до 24 месеца, освен ако закон не изисква повече.</li>
                <li>Необходими cookies – за времето на сесията/съответния срок.</li>
            </ul>
        </article>
    </section>

    <!-- Sharing -->
    <section class="mt-8 rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Споделяне с трети страни</h2>
        <ul class="mt-3 list-disc list-inside text-neutral-700 space-y-1">
            <li>Куриери (Еконт/Спиди) – за доставка.</li>
            <li>Платежни оператори (Stripe/PayPal) – за плащане.</li>
            <li>Хостинг/поддръжка – за надеждна работа на услугата.</li>
        </ul>
        <p class="mt-3 text-neutral-700">Данни се споделят само при необходимост и на основание договор/GDPR клаузи.</p>
    </section>

    <!-- Rights -->
    <section class="mt-8 rounded-2xl border bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold">Вашите права</h2>
        <ul class="mt-3 list-disc list-inside text-neutral-700 space-y-1">
            <li>Достъп до данните и копие.</li>
            <li>Корекция на неточни данни.</li>
            <li>Изтриване („право да бъдеш забравен“).</li>
            <li>Ограничаване/възражение срещу обработка.</li>
            <li>Преносимост на данните.</li>
            <li>Оттегляне на съгласие (когато основанието е съгласие).</li>
        </ul>
        <p class="mt-3 text-neutral-700">
            За да упражните права: пишете на <a class="underline"
                href="mailto:privacy@example.com">privacy@example.com</a>.
        </p>
    </section>

    <!-- Footer note -->
    <p class="mt-6 text-sm text-neutral-600">
        При промяна на услугите/доставчиците ще актуализираме тази политика и ще отразим датата по-горе.
    </p>
</section>
