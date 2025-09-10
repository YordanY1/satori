<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Author;
use Illuminate\Support\Str;
use App\Livewire\Concerns\UsesCart;

class AuthorShow extends Component
{
    use UsesCart;

    public string $slug;
    public array $author = [];
    public array $seo = [];

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        $a = Author::query()
            ->where('slug', $slug)
            ->with([
                'books:id,title,slug,price,cover,author_id',
                'quotes' => fn($q) => $q->published()->ordered(),
                'links'  => fn($q) => $q->published()->ordered(),
                'media'  => fn($q) => $q->published()->youtube()->ordered(),
            ])->firstOrFail();

        $photo = $a->photo
            ? (Str::startsWith($a->photo, ['http://', 'https://']) ? $a->photo : asset($a->photo))
            : asset('storage/authors/default.jpg');

        $books = $a->books->map(function ($b) {
            $cover = $b->cover
                ? (Str::startsWith($b->cover, ['http://', 'https://']) ? $b->cover : asset($b->cover))
                : asset('storage/images/default-book.jpg');
            return [
                'id'    => $b->id,
                'slug'  => $b->slug,
                'title' => $b->title,
                'price' => (float) $b->price,
                'cover' => $cover,
            ];
        })->toArray();

        $quotes = $a->quotes->pluck('quote')->all();

        $videos = $a->media->map(function ($m) {
            return [
                'type'  => 'youtube',
                'id'    => $m->youtube_id,
                'title' => $m->title ?? 'Видео',
            ];
        })->toArray();

        $interviews = $a->links->map(fn($l) => [
            'title' => $l->title,
            'url'   => $l->url,
        ])->toArray();

        $this->author = [
            'name'       => $a->name,
            'photo'      => $photo,
            'bio'        => $a->bio ?? '',
            'quotes'     => $quotes,
            'videos'     => $videos,
            'interviews' => $interviews,
            'books'      => $books,
        ];

        $this->seo = [
            'title' => $a->name . ' — Автор — Сатори Ко',
            'description' => Str::limit(strip_tags($a->bio ?? 'Открий книги и интервюта от автора ' . $a->name), 160),
            'keywords' => $a->name . ', книги, автор, писател, Сатори',
            'og:image' => $photo,
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "Person",
                "name" => $a->name,
                "image" => $photo,
                "description" => Str::limit(strip_tags($a->bio ?? ''), 200),
                "url" => url()->current(),
                "worksFor" => [
                    "@type" => "Organization",
                    "name" => "Сатори Ко"
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.author-show', [
            'author' => $this->author,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
