<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Post;

class BlogShow extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $this->post = Post::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.blog-show', [
            'post' => $this->post,
        ])->layout('layouts.app', [
            'title'       => $this->post->title . ' — Блог',
            'description' => str($this->post->excerpt ?? $this->post->content)->stripTags()->limit(160),
            'og_image'    => str($this->post->cover)->startsWith(['http://', 'https://'])
                ? $this->post->cover
                : asset($this->post->cover ?? 'storage/images/hero-1.jpg'),
        ]);
    }
}
