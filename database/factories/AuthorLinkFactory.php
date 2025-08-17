<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

class AuthorLinkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id'    => Author::factory(),
            'title'        => 'Интервю: ' . $this->faker->sentence(3),
            'url'          => $this->faker->url(),
            'is_published' => true,
            'position'     => 0,
        ];
    }
}
