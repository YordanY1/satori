<div class="space-y-3 text-sm text-gray-800">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div><strong>Фирма:</strong> {{ $order->invoice_company_name }}</div>
        <div><strong>ЕИК:</strong> {{ $order->invoice_eik }}</div>
        @if($order->invoice_vat_number)
            <div><strong>ЗДДС №:</strong> {{ $order->invoice_vat_number }}</div>
        @endif
        <div><strong>МОЛ:</strong> {{ $order->invoice_mol }}</div>
    </div>

    <div class="mt-3">
        <strong>Адрес:</strong><br>
        <span>{{ $order->invoice_address }}</span>
    </div>

    <div class="mt-4 border-t pt-3 text-xs text-gray-500">
        Създадена: {{ $order->created_at->format('d.m.Y H:i') }}
    </div>
</div>
