<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title'          => $this->faker->sentence(3),
            'slug'           => Str::slug($this->faker->unique()->sentence(3)),
            'description'    => $this->faker->realTextBetween(300, 600),
            'cover'          => 'storage/images/hero-1.jpg',
            'excerpt'        => 'storage/excerpts/presence.pdf',
            'price'          => $this->faker->randomFloat(2, 5, 50),
            'format'         => $this->faker->randomElement(['paper', 'ebook']),
            'author_id'      => Author::factory(),
            'is_book_of_month' => $this->faker->boolean(10),
            'is_recommended'   => $this->faker->boolean(30),
        ];
    }
}
