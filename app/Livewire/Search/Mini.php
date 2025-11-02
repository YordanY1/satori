<?php

namespace App\Livewire\Search;

use App\Models\Book;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Mini extends Component
{
    public string $q = '';
    public array $suggestions = [];

    public function updatedQ($value): void
    {
        $query = trim((string) $value);

        if ($query === '' || mb_strlen($query) < 2) {
            $this->suggestions = [];
            $this->dispatch('lw:debug', type: 'cleared', q: $query, count: 0);
            return;
        }

        try {
            $books = Book::query()
                ->where('title', 'like', '%' . $query . '%')
                ->orderBy('title')
                ->limit(5)
                ->get(['id', 'title', 'slug', 'cover']);

            $this->suggestions = $books->map(function ($book) {
                return [
                    'title' => $book->title,
                    'url'   => route('book.show', $book->slug),
                    'cover' => $book->cover
                        ? (Str::startsWith($book->cover, ['http://', 'https://'])
                            ? $book->cover
                            : asset('storage/' . ltrim($book->cover, '/')))
                        : asset('storage/images/default-book.jpg'),
                ];
            })->toArray();

            $this->dispatch('lw:debug', type: 'results', q: $query, count: count($this->suggestions));
        } catch (\Throwable $e) {
            Log::error('MiniSearch error: ' . $e->getMessage());
            $this->suggestions = [];
            $this->dispatch('lw:debug', type: 'error', message: $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.search.mini');
    }
}
