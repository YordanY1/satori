<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Str;

class BlogShow extends Component
{
    public Post $post;
    public array $seo = [];

    public function mount(string $slug): void
    {
        $this->post = Post::where('slug', $slug)->firstOrFail();

        $cover = $this->post->cover
            ? (Str::startsWith($this->post->cover, ['http://', 'https://'])
                ? $this->post->cover
                : asset($this->post->cover))
            : asset('storage/images/hero-1.jpg');

        $excerpt = $this->post->excerpt
            ?: Str::limit(strip_tags($this->post->content ?? ''), 160);

        $this->seo = [
            'title' => $this->post->title . ' — Блог — Сатори Ко',
            'description' => $excerpt,
            'keywords' => $this->post->title . ', блог, статия, книги, Сатори',
            'og:image' => $cover,
            'schema' => [
                "@context" => "https://schema.org",
                "@type" => "BlogPosting",
                "headline" => $this->post->title,
                "description" => $excerpt,
                "image" => $cover,
                "author" => [
                    "@type" => "Person",
                    "name" => $this->post->author ?? "Сатори Ко",
                ],
                "datePublished" => optional($this->post->created_at)->toIso8601String(),
                "dateModified" => optional($this->post->updated_at)->toIso8601String(),
                "mainEntityOfPage" => [
                    "@type" => "WebPage",
                    "@id" => url()->current()
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name" => "Сатори Ко",
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => asset('images/logo.png'),
                    ],
                ],
            ],
        ];
    }

    public function render()
    {
        return view('livewire.pages.blog-show', [
            'post' => $this->post,
        ])->layout('layouts.app', [
            'seo' => $this->seo,
        ]);
    }
}
