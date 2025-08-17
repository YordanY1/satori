<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Book;
use App\Livewire\Concerns\UsesCart;

class RecommendedBooks extends Component
{
    use UsesCart;

    public $books;

    public function mount()
    {
        $this->books = Book::query()
            ->where('is_recommended', true)
            ->latest()
            ->take(4)
            ->get(['id', 'title', 'slug', 'price', 'cover']);
    }

    public function render()
    {
        return view('livewire.home.recommended-books');
    }
}
