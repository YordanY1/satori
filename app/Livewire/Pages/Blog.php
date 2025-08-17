<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Illuminate\Support\Str;

class Blog extends Component
{
    use WithPagination;

    public string $q = '';
    public string $sort = 'new';

    protected $queryString = [
        'q'    => ['except' => ''],
        'sort' => ['except' => 'new'],
        'page' => ['except' => 1],
    ];

    public function updatedQ(): void
    {
        $this->resetPage();
    }
    public function updatedSort(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $q = Post::query()->select([
            'id',
            'title',
            'slug',
            'author',
            'excerpt',
            'content',
            'cover',
            'created_at'
        ]);

        if ($this->q !== '') {
            $q->where(function ($qq) {
                $qq->where('title', 'like', '%' . $this->q . '%')
                    ->orWhere('excerpt', 'like', '%' . $this->q . '%')
                    ->orWhere('content', 'like', '%' . $this->q . '%');
            });
        }

        match ($this->sort) {
            'title' => $q->orderBy('title'),
            default => $q->latest('created_at'),
        };

        $paginator = $q->paginate(12)->withQueryString();


        $posts = $paginator->through(function (Post $p) {
            $cover = $p->cover
                ? (Str::startsWith($p->cover, ['http://', 'https://']) ? $p->cover : asset($p->cover))
                : asset('storage/images/hero-1.jpg');

            return [
                'title'   => $p->title,
                'slug'    => $p->slug,
                'excerpt' => $p->excerpt ?: Str::limit(strip_tags($p->content ?? ''), 180),
                'cover'   => $cover,
                'author'  => $p->author ?? 'Неизвестен автор',
                'date'    => optional($p->created_at)->toDateString(),
            ];
        });

        return view('livewire.pages.blog', [
            'posts'      => $posts,
            'paginator'  => $paginator,
        ])->layout('layouts.app', [
            'title' => 'Блог — Сатори Ко',
        ]);
    }
}
