<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Потвърждение на поръчка</title>
</head>
<body style="margin:0; padding:0; background:#f9fafb; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f9fafb; padding:24px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="padding:24px; text-align:center; background:#111827; color:#ffffff;">
                            <h1 style="margin:0; font-size:20px; font-weight:bold;">Благодарим за поръчката!</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 16px; font-size:16px; color:#111827;">
                                Здравей, <strong>{{ $order->customer_name }}</strong>,
                            </p>
                            <p style="margin:0 0 16px; font-size:15px; color:#374151;">
                                Получихме твоята поръчка <strong>#{{ $order->order_number }}</strong>. Ето резюме:
                            </p>

                            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:16px; border-collapse:collapse;">
                                <thead>
                                    <tr style="background:#f3f4f6; text-align:left; font-size:14px; color:#374151;">
                                        <th style="padding:8px;">Продукт</th>
                                        <th style="padding:8px;">Количество</th>
                                        <th style="padding:8px; text-align:right;">Сума</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr style="border-bottom:1px solid #e5e7eb;">
                                        <td style="padding:8px; font-size:14px; color:#111827;">{{ $item->title }}</td>
                                        <td style="padding:8px; font-size:14px; color:#111827;">× {{ $item->quantity }}</td>
                                        <td style="padding:8px; font-size:14px; color:#111827; text-align:right;">
                                            {{ number_format($item->line_total, 2) }} {{ $order->currency }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <p style="margin:16px 0; font-size:16px; font-weight:bold; text-align:right; color:#111827;">
                                Общо: {{ number_format($order->total, 2) }} {{ $order->currency }}
                            </p>

                            <div style="margin-top:24px; text-align:center;">
                                <a href="{{ url('/') }}"
                                   style="display:inline-block; background:#2563eb; color:#ffffff; padding:12px 20px; font-size:15px; font-weight:600; text-decoration:none; border-radius:8px;">
                                    Посети нашия магазин
                                </a>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 24px; background:#f9fafb; text-align:center; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} {{ config('app.name') }}. Всички права запазени.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
