{{-- resources/views/emails/newsletter-confirm-html.blade.php --}}
@php
    $brandName = $brandName ?? config('app.name');
    $brandUrl = $brandUrl ?? config('app.url');
    $confirmUrl = $confirmUrl ?? '#';
    $unsubscribeUrl = $unsubscribeUrl ?? '#';
@endphp
<!doctype html>
<html lang="bg">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Потвърди абонамента</title>
   
    <style>
        .preheader {
            display: none !important;
            visibility: hidden;
            opacity: 0;
            color: transparent;
            height: 0;
            width: 0;
            overflow: hidden;
            mso-hide: all;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background: #0b1220 !important;
            }

            .container {
                background: #0f172a !important;
            }

            .text {
                color: #e5e7eb !important;
            }

            .muted {
                color: #94a3b8 !important;
            }

            .panel {
                background: #111827 !important;
                border-color: #1f2937 !important;
            }

            .btn {
                background: #22d3ee !important;
                border-color: #22d3ee !important;
                color: #000 !important;
            }
        }

        /* iOS link colors */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#f6f7fb;">
    <div class="preheader">Потвърди абонамента си и вземи безплатния PDF откъс.</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f6f7fb;">
        <tr>
            <td align="center" style="padding:24px 12px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" class="container"
                    style="width:100%; max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden;">

                    {{-- Body --}}
                    <tr>
                        <td style="padding:0 24px 8px 24px;">
                            <h1 class="text"
                                style="margin:0 0 8px 0; font-family:Arial,Helvetica,sans-serif; font-size:22px; line-height:1.3; color:#0f172a;">
                                Потвърди абонамента си
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 24px;">
                            <p class="text"
                                style="margin:0 0 14px 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#334155;">
                                Благодарим ти за интереса към нашия бюлетин! 🎉 С едно потвърждение ще получиш
                                <strong>безплатен PDF откъс от подбрана книга</strong> — директно в пощата си.
                            </p>
                        </td>
                    </tr>

                    {{-- Panel --}}
                    <tr>
                        <td style="padding:0 24px;">
                            <div class="panel"
                                style="background:#f1f5f9; border:1px solid #e5e7eb; border-radius:10px; padding:14px 16px;">
                                <p class="text"
                                    style="margin:0 0 6px 0; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#0f172a;">
                                    <strong>Какво получаваш след потвърждение:</strong>
                                </p>
                                <ul
                                    style="margin:0; padding-left:18px; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#334155; line-height:1.6;">
                                    <li>📘 Безплатен откъс (PDF) от нашата селекция за месеца</li>
                                    <li>📨 Бюлетин с практически идеи и кратки резюмета</li>
                                    <li>🎯 Рядко и само полезно съдържание — без спам</li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    {{-- Button --}}
                    <tr>
                        <td align="center" style="padding:22px 24px;">
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="btn" bgcolor="#0ea5e9" style="border-radius:10px;">
                                        <a href="{{ $confirmUrl }}" target="_blank"
                                            style="display:inline-block; padding:12px 20px; font-family:Arial,Helvetica,sans-serif; font-size:15px; font-weight:700; color:#ffffff; text-decoration:none; border:1px solid #0ea5e9; border-radius:10px;">
                                            Потвърди абонамента
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Fallback link --}}
                    <tr>
                        <td style="padding:0 24px;">
                            <p class="muted"
                                style="margin:0 0 16px 0; font-family:Arial,Helvetica,sans-serif; font-size:13px; line-height:1.6; color:#64748b;">
                                Ако бутонът не работи, копирай и отвори този линк:<br>
                                <a href="{{ $confirmUrl }}" target="_blank"
                                    style="color:#0ea5e9; word-break:break-all;">{{ $confirmUrl }}</a>
                            </p>
                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding:0 24px;">
                            <hr style="border:0; border-top:1px solid #e5e7eb; margin:8px 0 12px 0;">
                        </td>
                    </tr>

                    {{-- Extra text --}}
                    <tr>
                        <td style="padding:0 24px 10px 24px;">
                            <p class="text"
                                style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:14px; line-height:1.6; color:#334155;">
                                <strong>Нямаш време сега?</strong> Запази линка и се върни когато ти е удобно.
                                Ако това писмо не е било за теб — спокойно, можеш да се отпишеш по всяко време.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="padding:16px 24px 22px 24px;">
                            <p class="muted"
                                style="margin:0 0 6px 0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#6b7280;">
                                Не желаеш повече имейли? <a href="{{ $unsubscribeUrl }}" target="_blank"
                                    style="color:#0ea5e9;">Отпиши се</a>.
                            </p>
                            <p class="muted"
                                style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#9ca3af;">
                                © {{ date('Y') }} {{ $brandName }}. Всички права запазени.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
