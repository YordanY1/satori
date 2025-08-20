<?php

namespace App\Livewire\Faq;

use Livewire\Component;
use App\Models\Faq;

class Widget extends Component
{
    public string $q = '';
    public array $results = [];
    public array $suggested = [];
    public bool $open = false;

    public string $contact_name = '';
    public string $contact_email = '';
    public string $contact_message = '';

    protected $rules = [
        'contact_name' => 'required|string|min:2',
        'contact_email' => 'required|email',
        'contact_message' => 'required|string|min:10'
    ];

    public function mount(): void
    {
        $this->suggested = Faq::where('is_active', true)
            ->latest()->take(5)->get(['id', 'question', 'answer'])->toArray();
        $this->results = $this->suggested;
    }

    public function updatedQ(): void
    {
        $this->search();
    }

    public function search(): void
    {
        $this->results = Faq::search($this->q)->take(8)->get(['id', 'question', 'answer'])->toArray();
    }

    public function quickAsk(): void
    {
        $this->validate();

        // Тук можеш да пуснеш notification/мейл към екипа или да съхраниш в БД.
        // Примерно: \Mail::to(config('mail.from.address'))->send(new QuickQuestion(...));
        // За сега – само тост:
        $this->dispatch('notify', message: 'Получихме съобщението ти. Ще се свържем скоро.');

        // Clear:
        $this->contact_name = $this->contact_email = $this->contact_message = '';
        $this->open = false;
    }

    public function fillFromSuggestion($id): void
    {
        $row = Faq::find($id);
        if ($row) {
            $this->q = $row->question;
            $this->results = [$row->only(['id', 'question', 'answer'])];
        }
    }

    public function render()
    {
        return view('livewire.faq.widget');
    }
}
