<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class Contact extends Component
{
    public $name;
    public $email;
    public $message;

    protected $rules = [
        'name' => 'required|string|min:2',
        'email' => 'required|email',
        'message' => 'required|string|min:10',
    ];

    public function submit()
    {
        $this->validate();

        Mail::raw($this->message, function ($mail) {
            $mail->to('info@satori-ko.bg')
                ->subject('📩 Ново съобщение от контактната форма');
        });

        session()->flash('success', 'Благодарим! Ще се свържем с вас скоро.');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.pages.contact')->layout('layouts.app', [
            'title' => 'Контакт — Сатори Ко',
        ]);
    }
}
