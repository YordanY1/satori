<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Book;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Str;

class Hero extends Component
{
    public array $slides = [];
    public int $active = 0;

    public int $rotateEveryMs = 6000;

    public function mount(): void
    {
        $book  = Book::latest()->first();
        $event = Event::whereDate('date', '>=', now())->orderBy('date')->first();
        $post  = Post::latest()->first();

        $normUrl = function (?string $path, string $fallback) {
            if (!$path) return asset($fallback);
            return Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : asset($path);
        };

        $this->slides = collect([
            $book ? [
                'title'        => __('hero.book.title', ['title' => $book->title]),
                'subtitle'     => $book->excerpt ?: __('hero.book.subtitle_fallback'),
                'subtitle_url' => !empty($book->excerpt_url)
                    ? $normUrl($book->excerpt_url, '')
                    : null,
                'cta'          => [
                    'label' => __('hero.book.cta'),
                    'url'   => route('book.show', $book->slug),
                ],
                'image_url'    => $normUrl($book->cover, 'storage/images/hero-1.jpg'),
                'alt'          => __('hero.book.alt', ['title' => $book->title]),
            ] : null,

            $event ? [
                'title'        => __('hero.event.title', ['title' => $event->title]),
                'subtitle'     => $event->excerpt ?: __('hero.event.subtitle_fallback'),
                'subtitle_url' => null,
                'cta'          => [
                    'label' => __('hero.event.cta'),
                    'url'   => route('event.show', $event->slug),
                ],
                'image_url'    => $normUrl($event->cover, 'storage/images/hero-1.jpg'),
                'alt'          => __('hero.event.alt', ['title' => $event->title]),
            ] : null,

            $post ? [
                'title'        => $post->title,
                'subtitle'     => $post->excerpt ?: __('hero.post.subtitle_fallback'),
                'subtitle_url' => null,
                'cta'          => [
                    'label' => __('hero.post.cta'),
                    'url'   => route('blog.show', $post->slug),
                ],
                'image_url'    => $normUrl($post->cover, 'storage/images/hero-1.jpg'),
                'alt'          => __('hero.post.alt', ['title' => $post->title]),
            ] : null,
        ])->filter()->values()->toArray();


        if (count($this->slides) === 0) {
            $this->slides = [[
                'title'        => __('hero.empty.title'),
                'subtitle'     => __('hero.empty.subtitle'),
                'subtitle_url' => null,
                'cta'          => ['label' => __('hero.empty.cta'), 'url' => url('/')],
                'image_url'    => asset('storage/images/hero-1.jpg'),
                'alt'          => __('hero.empty.alt'),
            ]];
        }
    }

    public function next(): void
    {
        $c = count($this->slides);
        if ($c === 0) return;
        $this->active = ($this->active + 1) % $c;
    }

    public function prev(): void
    {
        $c = count($this->slides);
        if ($c === 0) return;
        $this->active = ($this->active - 1 + $c) % $c;
    }

    public function goTo(int $i): void
    {
        $c = count($this->slides);
        if ($c === 0) return;
        $this->active = max(0, min($i, $c - 1));
    }

    public function render()
    {
        return view('livewire.home.hero', ['slides' => $this->slides]);
    }
}
