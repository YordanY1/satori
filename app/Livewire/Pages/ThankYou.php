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

        Cart::clear();
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
    }

    protected function confirmPayPalOrder(string $paypalOrderId): void
    {
        try {
            $pp  = new \App\Support\PayPal();
            $res = $pp->captureOrder($paypalOrderId);

            if (($res['status'] ?? null) !== 'COMPLETED') {
                return;
            }


            $amountValue = $res['purchase_units'][0]['payments']['captures'][0]['amount']['value'] ?? null;
            $currency    = $res['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'] ?? null;


            $eurTotal = number_format($this->toEur($this->order->total), 2, '.', '');

            if ($amountValue !== $eurTotal || strtoupper((string) $currency) !== 'EUR') {
                return;
            }

            $this->order->forceFill([
                'payment_status' => 'paid',
                'paid_at'        => now(),
                'status'         => $this->order->status === 'pending' ? 'ready' : $this->order->status,
            ])->save();
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
