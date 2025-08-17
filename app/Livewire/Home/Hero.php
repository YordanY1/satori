<?php

namespace App\Livewire\Home;

use Livewire\Component;
use App\Models\Book;
use App\Models\Event;
use App\Models\Post;

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

        $this->slides = collect([
            $book ? [
                'title'    => "Нова книга: {$book->title}",
                'subtitle' => $book->excerpt ?: 'Виж детайлите за изданието!',
                'cta'      => ['label' => 'Виж книгата', 'url' => route('book.show', $book->slug)],
                'image'    => $book->cover ?: 'storage/images/hero-1.jpg',
                'alt'      => "Корица: {$book->title}",
            ] : null,

            $event ? [
                'title'    => "Събитие: {$event->title}",
                'subtitle' => $event->excerpt ?: 'Запази мястото си!',
                'cta'      => ['label' => 'Регистрирай се', 'url' => route('event.show', $event->slug)],
                'image'    => $event->cover ?: 'storage/images/hero-1.jpg',
                'alt'      => "Събитие: {$event->title}",
            ] : null,

            $post ? [
                'title'    => $post->title,
                'subtitle' => $post->excerpt ?: 'Прочети последната статия',
                'cta'      => ['label' => 'Виж статията', 'url' => route('blog.show', $post->slug)],
                'image'    => $post->cover ?: 'storage/images/hero-3.jpg',
                'alt'      => "Статия: {$post->title}",
            ] : null,
        ])->filter()->values()->toArray();

        if (count($this->slides) === 0) {
            $this->slides = [[
                'title'    => 'Очаквайте скоро',
                'subtitle' => 'Нови книги, събития и статии.',
                'cta'      => ['label' => 'Към началото', 'url' => url('/')],
                'image'    => 'storage/images/hero-1.jpg',
                'alt'      => 'Очаквайте скоро',
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
