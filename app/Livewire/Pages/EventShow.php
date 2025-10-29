<?php

namespace App\Livewire\Pages;

use App\Models\Event;
use Illuminate\Support\Str;
use Livewire\Component;

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
                : asset('storage/'.ltrim($e->cover, '/')))
            : asset('storage/images/default-event.jpg');

        $this->event = [
            'title' => $e->title,
            'slug' => $e->slug,
            'date' => optional($e->date)->toIso8601String(),
            'location' => $e->location,
            'program' => $e->program,
            'is_paid' => (bool) $e->is_paid,
            'payment_link' => $e->payment_link,
            'registration_link' => $e->registration_link,
            'video_url' => $e->video_url,
            'cover' => $cover,
        ];

        $desc = Str::limit(strip_tags($this->event['program'] ?? 'Събитие от Издателство Сатори'), 160);

        $this->seo = [
            'title' => $this->event['title'].' — Събитие — Издателство Сатори',
            'description' => $desc,
            'keywords' => $this->event['title'].', събитие, издателство сатори, лекция, уъркшоп',
            'canonical' => url()->current(),
            'og:title' => $this->event['title'].' — Издателство Сатори',
            'og:description' => $desc,
            'og:image' => $cover,
            'og:url' => url()->current(),
            'og:type' => 'event',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->event['title'].' — Събитие — Издателство Сатори',
            'twitter:description' => $desc,
            'twitter:image' => $cover,

            'schema' => [
                '@context' => 'https://schema.org',
                '@type' => 'Event',
                'name' => $this->event['title'],
                'description' => $desc,
                'image' => [$cover],
                'startDate' => $this->event['date'],
                'eventAttendanceMode' => $this->event['location']
                    ? 'https://schema.org/OfflineEventAttendanceMode'
                    : 'https://schema.org/OnlineEventAttendanceMode',
                'eventStatus' => 'https://schema.org/EventScheduled',
                'location' => [
                    '@type' => 'Place',
                    'name' => $this->event['location'] ?: 'Онлайн събитие',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'ж.к. Овча Купел 1, бл. 411, магазин 2',
                        'addressLocality' => 'София',
                        'postalCode' => '1632',
                        'addressCountry' => 'BG',
                    ],
                ],
                'organizer' => [
                    '@type' => 'Organization',
                    '@id' => url('#organization'),
                    'name' => 'Издателство Сатори',
                    'alternateName' => 'Сатори Ко',
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('images/logo.png'),
                    ],
                    'sameAs' => [
                        'https://www.facebook.com/VBelenski',
                    ],
                    'contactPoint' => [
                        [
                            '@type' => 'ContactPoint',
                            'contactType' => 'Customer Support',
                            'telephone' => '+359 87 849 0782',
                            'email' => 'izdatelstvosatori@gmail.com',
                            'areaServed' => 'BG',
                            'availableLanguage' => ['Bulgarian', 'English'],
                        ],
                    ],
                ],
                'offers' => [
                    '@type' => 'Offer',
                    'url' => $this->event['registration_link']
                        ?? $this->event['payment_link']
                        ?? url()->current(),
                    'price' => $this->event['is_paid'] ? '10.00' : '0.00',
                    'priceCurrency' => 'BGN',
                    'availability' => 'https://schema.org/InStock',
                    'validFrom' => now()->toIso8601String(),
                ],
            ],
        ];

        if (! empty($this->event['video_url'])) {
            $this->seo['schema']['video'] = [
                '@type' => 'VideoObject',
                'name' => $this->event['title'],
                'url' => $this->event['video_url'],
                'thumbnailUrl' => $cover,
            ];
        }
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
