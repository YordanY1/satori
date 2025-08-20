<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FavoriteButton extends Component
{
    public int $bookId;
    public bool $isFav = false;
    public int $count = 0;

    public function mount(int $bookId): void
    {
        $this->bookId = $bookId;

        $this->isFav = Auth::check()
            ? Favorite::where('user_id', Auth::id())->where('book_id', $bookId)->exists()
            : false;

        $this->count = Favorite::where('book_id', $bookId)->count();
    }

    public function toggle(): void
    {
        if (! Auth::check()) {
            $this->dispatch('auth:open', tab: 'login');
            $this->dispatch('notify', message: 'Моля, влез в профила си.');
            return;
        }

        $fav = Favorite::where('user_id', Auth::id())->where('book_id', $this->bookId)->first();

        if ($fav) {
            $fav->delete();
            $this->isFav = false;
            $this->count--;
        } else {
            Favorite::firstOrCreate([
                'user_id' => Auth::id(),
                'book_id' => $this->bookId,
            ]);
            $this->isFav = true;
            $this->count++;
        }
    }

    public function render()
    {
        return view('livewire.favorite-button');
    }
}
