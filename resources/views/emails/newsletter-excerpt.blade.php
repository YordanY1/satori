{{-- resources/views/emails/newsletter-excerpt.blade.php --}}
@php
    $brandName = $brandName ?? config('app.name');
    $brandUrl = $brandUrl ?? config('app.url');
    $downloadUrl = $downloadUrl ?? '#'; // линк към excerpt (ExcerptController)
    $unsubscribeUrl = $unsubscribeUrl ?? '#';
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Нов откъс от {{ $brandName }}</title>
    <style>
        .preheader {
            display: none !important;
            visibility: hidden;
            opacity: 0;
            height: 0;
            width: 0;
            overflow: hidden;
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

            .btn {
                background: #22d3ee !important;
                border-color: #22d3ee !important;
                color: #000 !important;
            }
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#f6f7fb;">
    <div class="preheader">Получавате нов безплатен откъс от {{ $brandName }}</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f6f7fb;">
        <tr>
            <td align="center" style="padding:24px 12px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" class="container"
                    style="width:100%; max-width:600px; background:#ffffff; border-radius:14px; overflow:hidden;">


                    <tr>
                        <td style="padding:24px;">
                            <h1
                                style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:22px; color:#0f172a;">
                                📖 Нов откъс: {{ $title ?? 'Неозаглавен' }}
                            </h1>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding:0 24px 16px 24px;">
                            <p class="text"
                                style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:16px; color:#334155;">
                                Благодарим, че си наш абонат! Можеш да свалиш откъса по-долу:
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:22px 24px;">
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="btn" bgcolor="#0ea5e9" style="border-radius:10px;">
                                        <a href="{{ $downloadUrl }}" target="_blank"
                                            style="display:inline-block; padding:12px 20px; font-family:Arial,Helvetica,sans-serif; font-size:15px; font-weight:700; color:#ffffff; text-decoration:none; border:1px solid #0ea5e9; border-radius:10px;">
                                            ⬇ Свали откъса (PDF)
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding:0 24px;">
                            <hr style="border:0; border-top:1px solid #e5e7eb; margin:8px 0 12px 0;">
                        </td>
                    </tr>

                   
                    <tr>
                        <td align="center" style="padding:16px 24px 22px 24px;">
                            <p class="muted"
                                style="margin:0 0 6px 0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#6b7280;">
                                Ако не желаеш да получаваш повече откъси, можеш да се
                                <a href="{{ $unsubscribeUrl }}" target="_blank" style="color:#0ea5e9;">отпишеш тук</a>.
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
