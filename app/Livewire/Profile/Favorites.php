<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class Favorites extends Component
{
    public function render(): View
    {
        $books = Auth::user()
            ->favoriteBooks()
            ->with('author:id,name')
            ->withCount('favoritedBy')
            ->latest('favorites.created_at')
            ->paginate(12);

        return view('livewire.profile.favorites', compact('books'))
            ->layout('layouts.app');
    }
}
