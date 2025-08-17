<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MediaFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return [
            'type'         => 'youtube',
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . Str::random(5),
            'youtube_id'   => 'dQw4w9WgXcQ',
            'audio_src'    => null,
            'thumbnail'    => null,
            'external_url' => null,
            'is_published' => true,
            'position'     => 0,
            'published_at' => now(),
        ];
    }

    public function youtube(string $id = 'dQw4w9WgXcQ'): self
    {
        return $this->state(fn() => [
            'type'       => 'youtube',
            'youtube_id' => $id,
            'audio_src'  => null,
        ]);
    }

    public function audio(string $src = 'storage/media/podcast-ep1.mp3'): self
    {
        return $this->state(function () {
            $title = 'Подкаст еп. ' . fake()->numberBetween(1, 99);
            return [
                'type'       => 'audio',
                'title'      => $title,
                'slug'       => Str::slug($title) . '-' . Str::random(5),
                'youtube_id' => null,
                'audio_src'  => 'storage/media/podcast-ep1.mp3',
            ];
        });
    }
}
