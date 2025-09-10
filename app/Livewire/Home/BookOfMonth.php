<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Book;
use App\Livewire\Concerns\UsesCart;

class BookOfMonth extends Component
{
    use UsesCart;

    public array $book = [];

    public function mount(): void
    {
        $bom = Book::where('is_book_of_month', true)
            ->latest('updated_at')
            ->first();

        if (!$bom) {
            $this->book = [
                'id'          => 0,
                'title'       => 'Скоро очаквайте!',
                'description' => 'Новата „Книга на месеца“ е на път.',
                'price'       => 0.00,
                'price_eur'   => null,
                'cover_url'   => asset('storage/images/hero-1.jpg'),
                'excerpt_url' => null,
                'slug'        => null,
            ];
            return;
        }

        $this->book = [
            'id'          => $bom->id,
            'title'       => $bom->title,
            'description' => $bom->description ?? '',
            'price'       => (float) $bom->price,
            'price_eur'   => (float) $bom->price_eur,
            'cover_url'   => str($bom->cover)->startsWith(['http://', 'https://'])
                ? $bom->cover
                : asset('storage/' . ltrim($bom->cover, '/')),
            'excerpt_url' => $bom->excerpt
                ? (str($bom->excerpt)->startsWith(['http://', 'https://'])
                    ? $bom->excerpt
                    : asset('storage/' . ltrim($bom->excerpt, '/')))
                : null,
            'slug'        => $bom->slug,
        ];
    }

    public function render()
    {
        return view('livewire.home.book-of-month');
    }
}
