<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;

class AuthorQuoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id'    => Author::factory(),
            'quote'        => '„' . $this->faker->sentence(8) . '“',
            'is_published' => true,
            'position'     => 0,
        ];
    }
}
