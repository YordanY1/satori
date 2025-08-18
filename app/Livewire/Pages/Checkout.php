<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use App\Support\PayPal;
use App\Support\Cart;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;

class Checkout extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $payment_method = 'cod'; // cod | stripe | paypal

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email',
        'phone' => 'required|string|min:8',
        'address' => 'required|string|min:5',
        'payment_method' => 'required|in:cod,stripe,paypal',
    ];

    public function placeOrder()
    {
        $this->validate();

        if (Cart::count() === 0) {
            $this->addError('cart', 'Количката е празна.');
            return;
        }

        return DB::transaction(function () {
            $items   = Cart::all();
            $bookIds = array_keys($items);
            $books   = Book::whereIn('id', $bookIds)->get(['id', 'title', 'price']);

            $subtotal   = 0.00;
            $normalized = [];

            foreach ($books as $book) {
                $qty  = max(1, (int) ($items[$book->id]['quantity'] ?? 1));
                $unit = (float) $book->price;
                $line = $unit * $qty;

                $subtotal += $line;

                $normalized[] = [
                    'book_id'    => $book->id,
                    'title'      => $book->title,
                    'unit_price' => $unit,
                    'quantity'   => $qty,
                    'line_total' => $line,
                ];
            }

            $discount = 0.00;
            $shipping = 0.00;
            $tax      = 0.00;
            $total    = $subtotal - $discount + $shipping + $tax;

            $order = Order::create([
                'public_id'        => (string) Str::uuid(),
                'order_number'     => $this->generateOrderNumber(),
                'customer_name'    => $this->name,
                'customer_email'   => $this->email,
                'customer_phone'   => $this->phone,
                'customer_address' => $this->address,
                'currency'         => 'BGN',
                'subtotal'         => round($subtotal, 2),
                'discount_total'   => round($discount, 2),
                'shipping_total'   => round($shipping, 2),
                'tax_total'        => round($tax, 2),
                'total'            => round($total, 2),
                'status'           => 'pending',
                'payment_method'   => $this->payment_method,
                'payment_status'   => 'pending',
            ]);

            foreach ($normalized as $n) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'book_id'    => $n['book_id'],
                    'title'      => $n['title'],
                    'unit_price' => round($n['unit_price'], 2),
                    'quantity'   => $n['quantity'],
                    'line_total' => round($n['line_total'], 2),
                ]);
            }

            // COD
            if ($this->payment_method === 'cod') {
                Cart::clear();
                $this->dispatch('notify', message: 'Благодарим! Поръчката е приета.');
                return $this->redirectRoute('thankyou', $order->id);
            }

            // STRIPE (Checkout Session, redirect)
            if ($this->payment_method === 'stripe') {
                try {
                    $stripe = new StripeClient(config('services.stripe.secret'));

                    $lineItems = array_map(function ($n) {
                        return [
                            'price_data' => [
                                'currency'     => 'bgn',
                                'product_data' => ['name' => $n['title']],
                                'unit_amount'  => (int) round($n['unit_price'] * 100),
                            ],
                            'quantity' => $n['quantity'],
                        ];
                    }, $normalized);

                    $session = $stripe->checkout->sessions->create([
                        'mode'                 => 'payment',
                        'payment_method_types' => ['card'],
                        'line_items'           => $lineItems,
                        'currency'             => 'bgn',
                        'customer_email'       => $this->email,
                        'metadata'             => [
                            'order_number' => $order->order_number,
                            'order_id'     => (string) $order->id,
                        ],
                        'success_url'          => route('thankyou', $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url'           => route('checkout'),
                    ]);

                    return $this->redirect($session->url);
                } catch (\Throwable $e) {
                    report($e);
                    $this->addError('cart', 'Stripe временно е недостъпен. Опитайте по-късно или изберете друг метод.');
                    return;
                }
            }

            // PAYPAL (Checkout – redirect)
            // ...
            if ($this->payment_method === 'paypal') {
                try {
                    $pp = new PayPal();

                    // Convert BGN to EUR for PayPal
                    $eurTotal = round($order->total / 1.95583, 2);

                    $created = $pp->createOrder(
                        currency: 'EUR',
                        amount: $eurTotal,
                        returnUrl: route('thankyou', $order->id),
                        cancelUrl: route('checkout'),
                        metadata: [
                            'order_number' => $order->order_number,
                            'orig_currency' => 'BGN',
                            'orig_total'    => number_format($order->total, 2, '.', ''),
                        ],
                        brandName: config('app.name', 'Store')
                    );

                    $approveUrl = PayPal::extractApproveLink($created);
                    if (!$approveUrl) {
                        $this->addError('cart', 'PayPal временно е недостъпен.');
                        return;
                    }

                    return $this->redirect($approveUrl);
                } catch (\Throwable $e) {
                    report($e);
                    $this->addError('cart', 'PayPal временно е недостъпен. Опитайте по-късно или изберете друг метод.');
                    return;
                }
            }


            // fallback
            Cart::clear();
            $this->dispatch('notify', message: 'Благодарим! Поръчката е приета.');
            return $this->redirectRoute('thankyou', $order->id);
        });
    }

    public function render()
    {
        return view('livewire.pages.checkout', [
            'cart'  => Cart::all(),
            'total' => Cart::total(),
        ])->layout('layouts.app', [
            'title' => 'Поръчка — Сатори Ко',
        ]);
    }

    private function generateOrderNumber(): string
    {
        $seq = (int) ((Order::max('id') ?? 0) + 1);
        return 'SO-' . now()->format('Y') . '-' . str_pad((string) $seq, 6, '0', STR_PAD_LEFT);
    }
}
