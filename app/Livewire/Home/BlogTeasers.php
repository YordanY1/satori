<?php

namespace App\Livewire\Home;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Component;

class BlogTeasers extends Component
{
    public array $posts = [];

    public function mount(): void
    {

        $posts = Post::query()
            ->latest('created_at')
            ->take(3)
            ->get(['title', 'slug', 'excerpt', 'cover', 'created_at']);

        $this->posts = $posts->map(function (Post $p) {
            $cover = $p->cover
                ? (Str::startsWith($p->cover, ['http://', 'https://'])
                    ? $p->cover
                    : asset('storage/'.ltrim($p->cover, '/')))
                : asset('storage/images/hero-1.jpg');

            return [
                'title' => $p->title,
                'excerpt' => $p->excerpt ?? Str::limit(strip_tags($p->content ?? ''), 160),
                'cover' => $cover,
                'url' => route('blog.show', $p->slug),
                'date' => optional($p->created_at)->toDateString(),
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.home.blog-teasers');
    }
}
