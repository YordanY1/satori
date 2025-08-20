<?php

namespace App\Livewire\Reviews;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use App\Models\Review;

class Form extends Component
{
    public int $bookId;

    public string $name = '';
    public int $rating = 0;
    public string $content = '';

    public function mount(int $bookId): void
    {
        $this->bookId = $bookId;
        if (Auth::check()) {
            $this->name = Auth::user()->name ?? '';
        }
    }

    protected function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:100'],
            'rating'  => ['required', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'content' => ['nullable', 'string', 'max:2000'],
        ];
    }

    protected function throttleKey(): string
    {
        return 'review|' . $this->bookId . '|' . mb_strtolower(trim($this->name)) . '|' . request()->ip();
    }

    public function submit(): void
    {
        $this->validate();

        $key = $this->throttleKey();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->addError('name', "Твърде много опити. Опитай след {$seconds} сек.");
            return;
        }

        Review::create([
            'book_id'   => $this->bookId,
            'user_id'   => Auth::id(),
            'user_name' => $this->name,
            'rating'    => $this->rating,
            'content'   => trim($this->content) ?: null,
        ]);

        RateLimiter::hit($key, 60);

        $this->dispatch('review:created');

        $this->reset(['rating', 'content']);

        $this->dispatch('notify', message: 'Благодарим за ревюто! ✅');
    }

    public function render()
    {
        return view('livewire.reviews.form');
    }
}
