<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Str;

class EventShow extends Component
{
    public array $event = [];
    public array $seo = [];

    public function mount(string $slug): void
    {
        $e = Event::where('slug', $slug)->firstOrFail();

        $cover = $e->cover
            ? (Str::startsWith($e->cover, ['http://', 'https://'])
                ? $e->cover
                : asset('storage/' . ltrim($e->cover, '/')))
            : asset('storage/images/default-event.jpg');

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


        $this->seo = [
            'title' => $this->event['title'] . ' — Събитие — Сатори Ко',
            'description' => Str::limit(strip_tags($this->event['program'] ?? 'Събитие от Сатори Ко'), 160),
            'keywords' => $this->event['title'] . ', събитие, Сатори',
            'og:image' => $cover,
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "Event",
                "name" => $this->event['title'],
                "startDate" => $this->event['date'],
                "eventAttendanceMode" => "https://schema.org/MixedEventAttendanceMode",
                "eventStatus" => "https://schema.org/EventScheduled",
                "location" => [
                    "@type" => "Place",
                    "name" => $this->event['location'] ?: "Онлайн",
                ],
                "image" => [$cover],
                "description" => Str::limit(strip_tags($this->event['program'] ?? ''), 200),
                "organizer" => [
                    "@type" => "Organization",
                    "name" => "Сатори Ко",
                    "url" => url('/'),
                ],
                "offers" => [
                    "@type" => "Offer",
                    "url" => url()->current(),
                    "price" => $this->event['is_paid'] ? "0.00" : "0.00",
                    "priceCurrency" => "BGN",
                    "availability" => "http://schema.org/InStock",
                    "validFrom" => now()->toIso8601String(),
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.event-show', [
            'event' => $this->event,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
