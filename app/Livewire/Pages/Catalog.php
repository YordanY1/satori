<?php

namespace App\Livewire\Pages;

use App\Livewire\Concerns\UsesCart;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Catalog extends Component
{
    use UsesCart, WithPagination;

    #[Url]
    public ?string $author = null; // slug or "0"

    #[Url]
    public ?string $genre = null;  // slug or "0"

    #[Url]
    public ?string $format = null;

    #[Url(except: 'popular')]
    public string $sort = 'popular';

    public array $authorOptions = [];

    public array $genreOptions = [];

    public array $seo = [];

    public function mount(): void
    {
        $this->authorOptions = Author::orderBy('name')->get(['id', 'name', 'slug'])->toArray();
        $this->genreOptions = Genre::orderBy('name')->get(['id', 'name', 'slug'])->toArray();

        $this->author ??= '0';
        $this->genre ??= '0';
        $this->format ??= '0';

        $this->generateSeo();
    }

    public function updated($field): void
    {
        if (in_array($field, ['author', 'genre', 'format', 'sort'])) {
            $this->resetPage();

            $this->author = $this->author !== '0'
                ? (Author::find((int) $this->author)->slug ?? '0')
                : '0';

            $this->genre = $this->genre !== '0'
                ? (Genre::find((int) $this->genre)->slug ?? '0')
                : '0';

            $this->generateSeo();
        }
    }

    protected function generateSeo(): void
    {
        $title = 'Каталог — Издателство Сатори';
        $description = 'Разгледай каталога на Издателство Сатори – книги по жанрове, автори и формати.';

        if ($this->author !== '0') {
            if ($m = Author::where('slug', $this->author)->first()) {
                $title = "Книги от {$m->name} — Издателство Сатори";
                $description = "Открий книги от {$m->name}.";
            }
        }

        if ($this->genre !== '0') {
            if ($g = Genre::where('slug', $this->genre)->first()) {
                $title = "Книги в жанр {$g->name} — Издателство Сатори";
                $description = "Разгледай книги в категория {$g->name}.";
            }
        }

        if ($this->format !== '0') {
            $formatName = $this->format === 'paper' ? 'Хартиено издание' : 'Е-книга';
            $title = "{$formatName} — Издателство Сатори";
            $description = "Разгледай книги във формат {$formatName}.";
        }

        $this->seo = [
            'title' => $title,
            'description' => $description,
            'canonical' => url()->current(),
            'og:title' => $title,
            'og:description' => $description,
            'og:type' => 'website',
            'og:image' => asset('images/og/catalog.jpg'),
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $title,
            'twitter:description' => $description,
            'twitter:image' => asset('images/og/catalog.jpg'),
        ];

        $this->seo['schema'] = [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $this->seo['title'],
            'description' => $this->seo['description'],
            'url' => url()->current(),
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Издателство Сатори',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
            ],
            'mainEntity' => [
                '@type' => 'ItemList',
                'itemListElement' => Book::latest()->take(12)->get()->map(fn ($b) => [
                    '@type' => 'ListItem',
                    'name' => $b->title,
                    'url' => route('book.show', $b->slug),
                ])->toArray(),
            ],
        ];
    }

    public function render()
    {
        $q = Book::query()
            ->with(['author:id,name,slug', 'genres:id,name,slug'])
            ->select(['id', 'title', 'slug', 'price', 'cover', 'format', 'author_id', 'price_eur']);

        if ($this->author !== '0') {
            if ($id = Author::where('slug', $this->author)->value('id')) {
                $q->where('author_id', $id);
            }
        }

        if ($this->genre !== '0') {
            if ($id = Genre::where('slug', $this->genre)->value('id')) {
                $q->whereHas('genres', fn ($g) => $g->where('genres.id', $id));
            }
        }

        if ($this->format !== '0') {
            $q->where('format', $this->format);
        }

        match ($this->sort) {
            'new' => $q->latest(),
            'price_asc' => $q->orderBy('price'),
            'price_desc' => $q->orderBy('price', 'desc'),
            default => $q->latest(),
        };

        $booksPaginator = $q->paginate(12);

        $books = $booksPaginator->through(function (Book $b) {
            $cover = $b->cover
                ? (Str::startsWith($b->cover, ['http://', 'https://'])
                    ? $b->cover
                    : asset('storage/'.ltrim($b->cover, '/')))
                : asset('storage/images/default-book.jpg');

            return [
                'id' => $b->id,
                'title' => $b->title,
                'price' => (float) $b->price,
                'price_eur' => (float) $b->price_eur,
                'slug' => $b->slug,
                'cover' => $cover,
            ];
        });

        return view('livewire.pages.catalog', [
            'books' => $books,
            'booksPaginator' => $booksPaginator,
            'authorOptions' => $this->authorOptions,
            'genreOptions' => $this->genreOptions,
        ])->layout('layouts.app', ['seo' => $this->seo]);
    }
}
