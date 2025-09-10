<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Str;

class Events extends Component
{
    public array $events = [];

    public function mount(): void
    {
        $this->events = Event::query()
            ->orderBy('date')
            ->get([
                'title',
                'slug',
                'date',
                'location',
                'program',
                'is_paid',
                'payment_link',
                'registration_link',
                'video_url',
                'cover',
            ])
            ->map(function (Event $e) {
                $cover = $e->cover
                    ? (Str::startsWith($e->cover, ['http://', 'https://'])
                        ? $e->cover
                        : asset('storage/' . ltrim($e->cover, '/')))
                    : asset('storage/images/default-event.jpg');

                return [
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
            })
            ->toArray();
    }

    public function render()
    {
        return view('livewire.pages.events', [
            'events' => $this->events,
        ])->layout('layouts.app', [
            'title' => 'Събития — Сатори Ко',
        ]);
    }
}
