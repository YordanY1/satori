<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Stripe\StripeClient;
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

        Cart::clear();
    }

    protected function confirmStripeSession(string $sessionId): void
    {
        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->retrieve($sessionId, [
            'expand' => ['payment_intent', 'line_items']
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

    public function render()
    {
        return view('livewire.pages.thank-you', [
            'order' => $this->order,
        ])->layout('layouts.app', [
            'title' => 'Благодарим за поръчката!',
        ]);
    }
}
