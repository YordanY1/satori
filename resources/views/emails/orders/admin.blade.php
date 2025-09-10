<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>Нова поръчка</title>
</head>
<body style="margin:0; padding:0; background:#f3f4f6; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f3f4f6; padding:24px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
                    <tr>
                        <td style="padding:24px; background:#dc2626; color:#ffffff; text-align:center;">
                            <h1 style="margin:0; font-size:20px; font-weight:bold;">Нова поръчка!</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 16px; font-size:15px; color:#111827;">
                                Нова поръчка с номер <strong>#{{ $order->order_number }}</strong>.
                            </p>

                            <p style="margin:0 0 16px; font-size:14px; color:#374151;">
                                <strong>Клиент:</strong> {{ $order->customer_name }}<br>
                                <strong>Имейл:</strong> {{ $order->customer_email }}<br>
                                <strong>Телефон:</strong> {{ $order->customer_phone }}<br>
                                <strong>Адрес:</strong> {{ $order->customer_address }}
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
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 24px; background:#f9fafb; text-align:center; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} {{ config('app.name') }}. Админ нотификация.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
