<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Stripe\StripeClient;
use App\Support\PayPal;
use App\Models\Order;
use App\Support\Cart;

class ThankYou extends Component
{
    public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;

        $sessionId = request('session_id');
        if ($sessionId && $this->order->payment_method === 'stripe' && $this->order->payment_status !== 'paid') {
            $this->confirmStripeSession($sessionId);
        }

        $paypalOrderId = request('token');
        if ($paypalOrderId && $this->order->payment_method === 'paypal' && $this->order->payment_status !== 'paid') {
            $this->confirmPayPalOrder($paypalOrderId);
        }
    }

    protected function confirmStripeSession(string $sessionId): void
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->retrieve($sessionId, [
            'expand' => ['payment_intent', 'line_items'],
        ]);

        if (($session->payment_status ?? null) !== 'paid') {
            return;
        }

        $metaOrderNumber = $session->metadata->order_number ?? null;
        if (!$metaOrderNumber || $metaOrderNumber !== $this->order->order_number) {
            return;
        }

        $sessionTotal = (int) $session->amount_total;
        $orderTotal   = (int) round($this->order->total * 100);
        if ($sessionTotal !== $orderTotal) {
            return;
        }

        $this->order->forceFill([
            'payment_status' => 'paid',
            'paid_at'        => now(),
            'status'         => $this->order->status === 'pending' ? 'ready' : $this->order->status,
        ])->save();

        $this->createEcontLabelFromLocalOrder();

        // Send emails after payment success
        try {
            \Mail::to($this->order->customer_email)
                ->send(new \App\Mail\OrderPlacedCustomerMail($this->order));

            \Mail::to(config('mail.admin_address', 'support@izdatelstvo-satori.com'))
                ->send(new \App\Mail\OrderPlacedAdminMail($this->order));
        } catch (\Throwable $e) {
            \Log::error('Email fail: ' . $e->getMessage());
        }

        Cart::clear();
    }

    protected function confirmPayPalOrder(string $paypalOrderId): void
    {
        try {
            if ($this->order->payment_status === 'paid') return;

            if (!empty($this->order->payment_reference) && $paypalOrderId !== $this->order->payment_reference) {
                \Log::warning('THANKYOU: PayPal token mismatch', [
                    'expected' => $this->order->payment_reference,
                    'got'      => $paypalOrderId,
                ]);
                return;
            }

            $pp  = app(\App\Support\PayPal::class);
            $res = $pp->captureOrder($paypalOrderId);
            if (($res['status'] ?? null) !== 'COMPLETED') return;

            $pu = $res['purchase_units'][0] ?? [];
            $cap = $pu['payments']['captures'][0] ?? [];

            $localId = $pu['custom_id'] ?? null;
            if (!$localId && !empty($pu['reference_id']) && str_starts_with($pu['reference_id'], 'order-')) {
                $localId = substr($pu['reference_id'], 6);
            }
            if (!$localId && !empty($cap['invoice_id']) && str_starts_with($cap['invoice_id'], 'INV-')) {
                $localId = substr($cap['invoice_id'], 4);
            }

            if ($localId && (int)$localId !== (int)$this->order->id) {
                \Log::warning('THANKYOU: local order id mismatch', compact('localId'));
                return;
            }

            $amountValue = (float)($cap['amount']['value'] ?? 0);
            $currency    = strtoupper((string)($cap['amount']['currency_code'] ?? ''));
            $eurTotal    = round($this->toEur($this->order->total), 2);

            if ($currency !== 'EUR' || abs($amountValue - $eurTotal) > 0.01) {
                \Log::warning('THANKYOU: PayPal amount mismatch', compact('amountValue', 'eurTotal', 'currency'));
                return;
            }

            $this->order->forceFill([
                'payment_status' => 'paid',
                'paid_at'        => now(),
                'status'         => $this->order->status === 'pending' ? 'ready' : $this->order->status,
            ])->save();

            $this->createEcontLabelFromLocalOrder();

            Cart::clear();
        } catch (\Throwable $e) {
            report($e);
        }
    }

    protected function createEcontLabelFromLocalOrder(): void
    {
        try {
            if ($this->order->shipping_provider === 'econt' && !empty($this->order->shipping_payload)) {
                return;
            }

            $draft = $this->order->shipping_draft ?? [];
            if (!is_array($draft) || empty($draft)) {
                \Log::warning('THANKYOU:Econt skip - empty shipping_draft', ['order_id' => $this->order->id]);
                return;
            }

            $receiver = [
                'name'         => $this->order->customer_name ?: ($draft['receiver']['name'] ?? ''),
                'phone'        => preg_replace('/\s+/', '', $this->order->customer_phone ?: ($draft['receiver']['phone'] ?? '')),
                'city_id'      => ($draft['method'] ?? '') === 'address' ? ($draft['receiver']['city_id'] ?? null) : null,
                'office_code'  => ($draft['method'] ?? '') === 'econt_office' ? ($draft['receiver_office_code'] ?? null) : null,
                'street_label' => $draft['receiver']['street_label'] ?? null,
                'street_num'   => $draft['receiver']['street_num'] ?? null,
            ];

            if (!$receiver['city_id'] && !$receiver['office_code']) {
                \Log::warning('THANKYOU:Econt skip - missing destination (draft)', ['order_id' => $this->order->id]);
                return;
            }

            $labelInput = [
                'sender' => [
                    'name'      => config('shipping.econt.sender_name'),
                    'phone'     => config('shipping.econt.sender_phone'),
                    'city_name' => config('shipping.econt.sender_city'),
                    'post_code' => config('shipping.econt.sender_post'),
                    'street'    => config('shipping.econt.sender_street'),
                    'num'       => config('shipping.econt.sender_num'),
                ],
                'receiver'     => $receiver,
                'pack_count'   => 1,
                'weight'       => (float)($draft['weight'] ?? 0.5),
                'description'  => $draft['description'] ?? 'Книги',
            ];

            $labelService = app(\App\Services\Shipping\EcontLabelService::class);
            $label = $labelService->validateThenCreate($labelInput);

            $this->order->update([
                'shipping_provider' => 'econt',
                'shipping_payload'  => $label,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    private function toEur(float $bgn): float
    {
        return round($bgn / 1.95583, 2);
    }

    public function render()
    {
        return view('livewire.pages.thank-you', [
            'order' => $this->order,
        ])->layout('layouts.app', [
            'title' => 'Благодарим за поръчката!',
        ]);
    }
}
