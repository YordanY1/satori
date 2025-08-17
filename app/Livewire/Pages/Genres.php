<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Genre;

class Genres extends Component
{
    public function render()
    {
        $genres = Genre::orderBy('name')->get(['id', 'name', 'slug']);

        return view('livewire.pages.genres', compact('genres'))
            ->layout('layouts.app', [
                'title' => 'Жанрове и Теми — Сатори Ко',
            ]);
    }
}
