{{-- resources/views/emails/newsletter-confirm-html.blade.php --}}
@php
    $brandName = $brandName ?? config('app.name');
    $brandUrl = $brandUrl ?? config('app.url');
    $confirmUrl = $confirmUrl ?? '#';
    $unsubscribeUrl = $unsubscribeUrl ?? '#';
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ __('newsletter.subject') }}</title>
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

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
    </style>
</head>

<body style="margin:0; padding:0; background:#f6f7fb;">
    <div class="preheader">{{ __('newsletter.preheader') }}</div>
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
                                {{ __('newsletter.title') }}
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 24px;">
                            <p class="text"
                                style="margin:0 0 14px 0; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6; color:#334155;">
                                {!! __('newsletter.thanks') !!}
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
                                    <strong>{{ __('newsletter.panel_title') }}</strong>
                                </p>
                                <ul
                                    style="margin:0; padding-left:18px; font-family:Arial,Helvetica,sans-serif; font-size:14px; color:#334155; line-height:1.6;">
                                    <li>{{ __('newsletter.panel_items.pdf') }}</li>
                                    <li>{{ __('newsletter.panel_items.newsletter') }}</li>
                                    <li>{{ __('newsletter.panel_items.no_spam') }}</li>
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
                                            {{ __('newsletter.button') }}
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
                                {{ __('newsletter.fallback') }}<br>
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
                                {{ __('newsletter.extra') }}
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="padding:16px 24px 22px 24px;">
                            <p class="muted"
                                style="margin:0 0 6px 0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#6b7280;">
                                {{ __('newsletter.unsubscribe') }}
                                <a href="{{ $unsubscribeUrl }}" target="_blank"
                                    style="color:#0ea5e9;">{{ __('newsletter.unsubscribe_link') }}</a>.
                            </p>
                            <p class="muted"
                                style="margin:0; font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#9ca3af;">
                                © {{ date('Y') }} {{ $brandName }}. {{ __('newsletter.rights') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
