<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title'   => $this->faker->sentence,
            'slug'    => $this->faker->unique()->slug,
            'author'  => $this->faker->name, 
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(5, true),
            'cover'   => 'storage/images/hero-1.jpg',
        ];
    }
}
