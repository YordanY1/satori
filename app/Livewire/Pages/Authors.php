<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Author;

class Authors extends Component
{
    public $authors;

    public function mount(): void
    {
        $this->authors = Author::orderBy('name')
            ->get(['id', 'name', 'slug', 'photo']);
    }

    public function render()
    {
        return view('livewire.pages.authors', [
            'authors' => $this->authors,
        ])->layout('layouts.app', [
            'title' => 'Автори — Сатори Ко',
        ]);
    }
}
