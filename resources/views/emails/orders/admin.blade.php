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
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
                    style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.05);">
                    {{-- Header --}}
                    <tr>
                        <td style="padding:24px; background:#dc2626; color:#ffffff; text-align:center;">
                            <h1 style="margin:0; font-size:20px; font-weight:bold;">Нова поръчка!</h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:24px;">
                            <p style="margin:0 0 16px; font-size:15px; color:#111827;">
                                Получена е нова поръчка с номер <strong>#{{ $order->order_number }}</strong>.
                            </p>

                            {{-- Customer info --}}
                            <p style="margin:0 0 16px; font-size:14px; color:#374151;">
                                <strong>Клиент:</strong> {{ $order->customer_name }}<br>
                                <strong>Имейл:</strong> {{ $order->customer_email }}<br>
                                <strong>Телефон:</strong> {{ $order->customer_phone }}<br>
                                {{-- @if ($order->shipping_method === 'econt_office')
                                    <strong>Офис на Еконт:</strong>
                                    {{ data_get($order->shipping_draft, 'receiver_office_code') ?? '—' }}
                                @else
                                    <strong>Адрес за доставка:</strong> {{ $order->full_shipping_address }}
                                @endif --}}
                            </p>

                            {{-- Invoice info (if applicable) --}}
                            @if ($order->needs_invoice)
                                <div style="margin:16px 0; padding:12px 16px; background:#fef3c7; border-radius:8px;">
                                    <p style="margin:0 0 8px; font-size:15px; font-weight:bold; color:#92400e;">Фактурни
                                        данни</p>
                                    <p style="margin:0; font-size:14px; color:#78350f;">
                                        <strong>Фирма:</strong> {{ $order->invoice_company_name }}<br>
                                        <strong>ЕИК:</strong> {{ $order->invoice_eik }}<br>
                                        @if ($order->invoice_vat_number)
                                            <strong>ЗДДС №:</strong> {{ $order->invoice_vat_number }}<br>
                                        @endif
                                        <strong>МОЛ:</strong> {{ $order->invoice_mol }}<br>
                                        <strong>Адрес:</strong> {{ $order->invoice_address }}
                                    </p>
                                </div>
                            @endif

                            {{-- Order items --}}
                            <table width="100%" cellspacing="0" cellpadding="0"
                                style="margin-top:16px; border-collapse:collapse;">
                                <thead>
                                    <tr style="background:#f3f4f6; text-align:left; font-size:14px; color:#374151;">
                                        <th style="padding:8px;">Продукт</th>
                                        <th style="padding:8px;">Количество</th>
                                        <th style="padding:8px; text-align:right;">Сума</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr style="border-bottom:1px solid #e5e7eb;">
                                            <td style="padding:8px; font-size:14px; color:#111827;">{{ $item->title }}
                                            </td>
                                            <td style="padding:8px; font-size:14px; color:#111827;">×
                                                {{ $item->quantity }}</td>
                                            <td style="padding:8px; font-size:14px; color:#111827; text-align:right;">
                                                {{ number_format($item->line_total, 2) }} {{ $order->currency }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Totals --}}
                            <table width="100%" cellspacing="0" cellpadding="0"
                                style="margin-top:16px; font-size:14px; color:#111827;">
                                <tr>
                                    <td style="padding:4px 8px;">Междинна сума:</td>
                                    <td style="padding:4px 8px; text-align:right;">
                                        {{ number_format($order->subtotal, 2) }} {{ $order->currency }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 8px;">Доставка:</td>
                                    <td style="padding:4px 8px; text-align:right;">
                                        {{ number_format($order->shipping_total, 2) }} {{ $order->currency }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 8px;">Отстъпка:</td>
                                    <td style="padding:4px 8px; text-align:right;">
                                        {{ number_format($order->discount_total, 2) }} {{ $order->currency }}</td>
                                </tr>
                                <tr style="font-weight:bold;">
                                    <td style="padding:8px 8px;">Общо за плащане:</td>
                                    <td style="padding:8px 8px; text-align:right;">
                                        {{ number_format($order->total, 2) }} {{ $order->currency }}</td>
                                </tr>
                            </table>

                            {{-- Payment & Shipping --}}
                            <p style="margin-top:16px; font-size:14px; color:#374151;">
                                <strong>Метод на плащане:</strong>
                                @switch($order->payment_method)
                                    @case('cod')
                                        Наложен платеж
                                    @break

                                    @case('paypal')
                                        PayPal
                                    @break

                                    @case('stripe')
                                        Карта (Stripe)
                                    @break

                                    @default
                                        {{ $order->payment_method }}
                                @endswitch
                                <br>
                                <strong>Метод на доставка:</strong>
                                {{ $order->shipping_method === 'econt_office' ? 'Еконт офис' : 'До адрес' }}
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="padding:16px 24px; background:#f9fafb; text-align:center; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} {{ config('app.name') }}. Админ нотификация.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
