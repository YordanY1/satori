<?php

namespace App\Support;

class Cart
{
    public static function all(): array
    {
        return session('cart', []);
    }

    public static function count(): int
    {
        return collect(self::all())->sum('quantity');
    }

    public static function total(): float
    {
        return round(collect(self::all())->sum(fn($i) => $i['price'] * $i['quantity']), 2);
    }

    public static function put(int $bookId, array $payload): void
    {
        $cart = self::all();
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity'] += $payload['quantity'] ?? 1;
        } else {
            $cart[$bookId] = $payload + ['quantity' => 1];
        }
        session()->put('cart', $cart);
    }

    public static function increment(int $bookId): void
    {
        $cart = self::all();
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity']++;
            session()->put('cart', $cart);
        }
    }

    public static function decrement(int $bookId): void
    {
        $cart = self::all();
        if (isset($cart[$bookId])) {
            $cart[$bookId]['quantity']--;
            if ($cart[$bookId]['quantity'] <= 0) unset($cart[$bookId]);
            session()->put('cart', $cart);
        }
    }

    public static function remove(int $bookId): void
    {
        $cart = self::all();
        unset($cart[$bookId]);
        session()->put('cart', $cart);
    }

    public static function clear(): void
    {
        session()->forget('cart');
    }
}
