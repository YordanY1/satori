<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
    public string $payment_method = 'cod';

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email',
        'phone' => 'required|string|min:8',
        'address' => 'required|string|min:5',
        'payment_method' => 'required|in:cod,paypal,stripe',
    ];

    public function placeOrder()
    {
        $this->validate();

        if (Cart::count() === 0) {
            $this->dispatch('notify', message: 'Количката е празна.');
            return;
        }

        DB::transaction(function () {
            $items = Cart::all();
            $bookIds = array_keys($items);

            $books = Book::whereIn('id', $bookIds)->get(['id', 'title', 'price']);

            $subtotal = 0.00;
            $normalized = [];

            foreach ($books as $book) {
                $qty       = max(1, (int)($items[$book->id]['quantity'] ?? 1));
                $unitPrice = (float) $book->price;
                $lineTotal = $unitPrice * $qty;

                $subtotal += $lineTotal;

                $normalized[] = [
                    'book_id'    => $book->id,
                    'title'      => $book->title,
                    'unit_price' => $unitPrice,
                    'quantity'   => $qty,
                    'line_total' => $lineTotal,
                    'sku'        => null,
                    'isbn'       => null,
                    'tax_rate'   => 0.00,
                    'tax_amount' => 0.00,
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
                'paid_at'          => null,
                'notes'            => null,
                'shipping_method'  => null,
                'tracking_number'  => null,
            ]);

            foreach ($normalized as $n) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'book_id'    => $n['book_id'],
                    'title'      => $n['title'],
                    'unit_price' => round($n['unit_price'], 2),
                    'quantity'   => $n['quantity'],
                    'line_total' => round($n['line_total'], 2),
                    'sku'        => $n['sku'],
                    'isbn'       => $n['isbn'],
                    'tax_rate'   => $n['tax_rate'],
                    'tax_amount' => $n['tax_amount'],
                ]);
            }

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
