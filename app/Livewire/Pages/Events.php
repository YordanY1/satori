<?php

namespace App\Livewire\Pages;

use App\Models\Event;
use Illuminate\Support\Str;
use Livewire\Component;

class Events extends Component
{
    public array $events = [];

    public array $seo = [];

    public function mount(): void
    {
        $this->events = Event::query()
            ->orderBy('date', 'asc')
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
                        : asset('storage/'.ltrim($e->cover, '/')))
                    : asset('storage/images/default-event.jpg');

                return [
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
            })
            ->toArray();

        // Основни мета данни
        $this->seo = [
            'title' => 'Събития — Издателство Сатори',
            'description' => 'Разгледай всички събития, организирани от Издателство Сатори — лекции, уъркшопи, презентации и духовни срещи в София и онлайн.',
            'keywords' => 'издателство сатори, събития, лекции, курсове, уъркшопи, духовност, философия',
            'canonical' => url()->current(),
            'og:title' => 'Събития — Издателство Сатори',
            'og:description' => 'Предстоящи и минали събития, организирани от Издателство Сатори.',
            'og:image' => asset('images/logo.png'),
            'og:url' => url()->current(),
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:title' => 'Събития — Издателство Сатори',
            'twitter:description' => 'Лекции, курсове и вдъхновяващи събития от Издателство Сатори.',
            'twitter:image' => asset('images/og/events.jpg'),
        ];

        // Schema.org с event списък
        $this->seo['schema'] = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => 'Събития — Издателство Сатори',
            'description' => 'Предстоящи и минали събития, организирани от Издателство Сатори.',
            'url' => url()->current(),
            'publisher' => [
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
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'ж.к. Овча Купел 1, бл. 411, магазин 2',
                    'addressLocality' => 'София',
                    'postalCode' => '1632',
                    'addressCountry' => 'BG',
                ],
            ],
            'mainEntity' => [
                '@type' => 'ItemList',
                'name' => 'Събития на Издателство Сатори',
                'itemListElement' => collect($this->events)->map(function ($event, $i) {
                    $item = [
                        '@type' => 'Event',
                        'position' => $i + 1,
                        'name' => $event['title'],
                        'startDate' => $event['date'],
                        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
                        'eventStatus' => 'https://schema.org/EventScheduled',
                        'url' => route('event.show', $event['slug']),
                        'image' => $event['cover'],
                        'location' => [
                            '@type' => 'Place',
                            'name' => $event['location'] ?: 'България',
                            'address' => [
                                '@type' => 'PostalAddress',
                                'addressCountry' => 'BG',
                            ],
                        ],
                        'organizer' => [
                            '@type' => 'Organization',
                            'name' => 'Издателство Сатори',
                            'url' => url('/'),
                        ],
                    ];

                    if ($event['is_paid']) {
                        $item['offers'] = [
                            '@type' => 'Offer',
                            'url' => $event['payment_link'] ?? $event['registration_link'] ?? route('event.show', $event['slug']),
                            'price' => '0.00',
                            'priceCurrency' => 'BGN',
                            'availability' => 'https://schema.org/InStock',
                        ];
                    }

                    if ($event['video_url']) {
                        $item['video'] = [
                            '@type' => 'VideoObject',
                            'name' => $event['title'],
                            'url' => $event['video_url'],
                        ];
                    }

                    return $item;
                })->toArray(),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.events', [
            'events' => $this->events,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
