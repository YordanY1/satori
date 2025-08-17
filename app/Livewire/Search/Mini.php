<?php

namespace App\Livewire\Search;

use Livewire\Component;

class Mini extends Component
{
    public string $q = '';
    public array $suggestions = [];

    public function updatedQ()
    {
        // TODO: замени със Scout/Meilisearch по-късно
        $this->suggestions = $this->q
            ? [
                ['title' => 'Безшумният ум', 'url' => '/catalog'],
                ['title' => 'Дзен и дишане', 'url' => '/catalog'],
            ]
            : [];
    }

    public function render() { return view('livewire.search.mini'); }
}
