<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book; 

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'user_name' => $this->faker->name,
            'rating' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->paragraph,
        ];
    }
}
