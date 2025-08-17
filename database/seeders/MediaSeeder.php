<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Media;
use Illuminate\Support\Str;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        
        Media::updateOrCreate(
            ['slug' => 'treilar-prisastvie'],
            [
                'type'         => 'youtube',
                'title'        => 'Трейлър: Присъствие',
                'youtube_id'   => 'dQw4w9WgXcQ',
                'external_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'is_published' => true,
                'position'     => 1,
                'published_at' => now()->subDays(1),
            ]
        );


        Media::updateOrCreate(
            ['slug' => 'podkast-ep-1'],
            [
                'type'         => 'audio',
                'title'        => 'Подкаст еп. 1',
                'audio_src'    => 'storage/media/podcast-ep1.mp3',
                'is_published' => true,
                'position'     => 2,
                'published_at' => now(),
            ]
        );
    }
}
