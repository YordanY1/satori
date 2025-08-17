<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Str;

class EventShow extends Component
{
    public array $event = [];

    public function mount(string $slug): void
    {
        $e = Event::where('slug', $slug)->firstOrFail();

        $cover = $e->cover
            ? (Str::startsWith($e->cover, ['http://', 'https://']) ? $e->cover : asset($e->cover))
            : null;

        $this->event = [
            'title'             => $e->title,
            'slug'              => $e->slug,
            'date'              => optional($e->date)->toIso8601String(),
            'location'          => $e->location,
            'program'           => $e->program,
            'is_paid'           => (bool) $e->is_paid,
            'payment_link'      => $e->payment_link,
            'registration_link' => $e->registration_link,
            'video_url'         => $e->video_url,
            'cover'             => $cover,
        ];
    }

    public function render()
    {
        return view('livewire.pages.event-show', [
            'event' => $this->event,
        ])->layout('layouts.app', [
            'title' => $this->event['title'] . ' — Събитие — Сатори Ко',
        ]);
    }
}
