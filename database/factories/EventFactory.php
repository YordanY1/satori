<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'             => $this->faker->sentence(3),
            'slug'              => $this->faker->unique()->slug,
            'date'              => $this->faker->dateTimeBetween('now', '+1 year'),
            'location'          => $this->faker->city,
            'program'           => $this->faker->paragraph(5),
            'is_paid'           => $this->faker->boolean,
            'payment_link'      => 'https://example.com/pay',
            'registration_link' => 'https://example.com/register',
            'video_url'         => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'cover'             => 'storage/event/event.jpg',
        ];
    }
}
