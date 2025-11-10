<?php

namespace App\Livewire\Home;

use App\Models\Book;
use App\Models\Event;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\SiteSetting;


class Hero extends Component
{
    public array $slides = [];

    public int $active = 0;

    public int $rotateEveryMs = 6000;

    public function mount(): void
    {

        $featuredBookId = SiteSetting::get('featured_book_id');
        $featuredEventId = SiteSetting::get('featured_event_id');
        $featuredPostId = SiteSetting::get('featured_post_id');


        $book = $featuredBookId ? Book::find($featuredBookId) : null;
        if (! $book) {
            $book = Book::latest()->first();
        }

        $event = $featuredEventId ? Event::find($featuredEventId) : null;
        if (! $event) {
            $event = Event::whereDate('date', '>=', now())->orderBy('date')->first();
        }

        $post = $featuredPostId ? Post::find($featuredPostId) : null;
        if (! $post) {
            $post = Post::latest()->first();
        }


        $normUrl = function (?string $path, string $fallback) {
            if (! $path) {
                return asset($fallback);
            }

            return Str::startsWith($path, ['http://', 'https://'])
                ? $path
                : asset('storage/' . ltrim($path, '/'));
        };

        $this->slides = collect([
            $book ? [
                'title' => __('hero.book.title', ['title' => $book->title]),
                'subtitle' => $book->excerpt ?: __('hero.book.subtitle_fallback'),
                'subtitle_url' => ! empty($book->excerpt_url)
                    ? $normUrl($book->excerpt_url, 'storage/images/hero-1.jpg')
                    : null,
                'cta' => [
                    'label' => __('hero.book.cta'),
                    'url' => route('book.show', $book->slug),
                ],
                'image_url' => $normUrl($book->cover, 'storage/images/hero-1.jpg'),
                'alt' => __('hero.book.alt', ['title' => $book->title]),
            ] : null,

            $event ? [
                'title' => __('hero.event.title', ['title' => $event->title]),
                'subtitle' => $event->excerpt ?: __('hero.event.subtitle_fallback'),
                'subtitle_url' => null,
                'cta' => [
                    'label' => __('hero.event.cta'),
                    'url' => route('event.show', $event->slug),
                ],
                'image_url' => $normUrl($event->cover, 'storage/images/hero-1.jpg'),
                'alt' => __('hero.event.alt', ['title' => $event->title]),
            ] : null,

            $post ? [
                'title' => $post->title,
                'subtitle' => $post->excerpt ?: __('hero.post.subtitle_fallback'),
                'subtitle_url' => null,
                'cta' => [
                    'label' => __('hero.post.cta'),
                    'url' => route('blog.show', $post->slug),
                ],
                'image_url' => $normUrl($post->cover, 'storage/images/hero-1.jpg'),
                'alt' => __('hero.post.alt', ['title' => $post->title]),
            ] : null,
        ])
            ->filter()
            ->values()
            ->toArray();

        // 🔥 Това е ключът: ако няма слайдове, излизаме без да пълним нищо
        if (count($this->slides) === 0) {
            return;
        }
    }

    public function next(): void
    {
        $c = count($this->slides);
        if ($c === 0) {
            return;
        }
        $this->active = ($this->active + 1) % $c;
    }

    public function prev(): void
    {
        $c = count($this->slides);
        if ($c === 0) {
            return;
        }
        $this->active = ($this->active - 1 + $c) % $c;
    }

    public function goTo(int $i): void
    {
        $c = count($this->slides);
        if ($c === 0) {
            return;
        }
        $this->active = max(0, min($i, $c - 1));
    }

    public function render()
    {
        return view('livewire.home.hero', ['slides' => $this->slides]);
    }
}
