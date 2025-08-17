<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Author, AuthorQuote, AuthorLink, Media};

class AuthorExtrasSeeder extends Seeder
{
    public function run(): void
    {
        $author = Author::first() ?? Author::factory()->create([
            'name' => 'Екхарт Толе',
            'slug' => 'eckhart-tolle',
            'photo' => 'storage/authors/tolle.jpg',
        ]);

        AuthorQuote::updateOrCreate(
            ['author_id' => $author->id, 'quote' => 'Дълбокият вътрешен мир идва, когато приемеш настоящия момент.']
        );
        AuthorQuote::updateOrCreate(
            ['author_id' => $author->id, 'quote' => 'Съзнанието е ключът към свободата.']
        );

        AuthorLink::updateOrCreate(
            ['author_id' => $author->id, 'title' => 'Интервю за осъзнатостта', 'url' => 'https://example.com/interview']
        );
        AuthorLink::updateOrCreate(
            ['author_id' => $author->id, 'title' => 'Подкаст: Живот в настоящето', 'url' => 'https://example.com/podcast']
        );

        Media::updateOrCreate(
            ['slug' => 'video-predstaviane-' . $author->id],
            [
                'author_id'   => $author->id,
                'type'        => 'youtube',
                'title'       => 'Видео представяне',
                'youtube_id'  => 'dQw4w9WgXcQ',
                'is_published' => true,
                'position'    => 1,
                'published_at' => now(),
            ]
        );
    }
}
