<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $photos = [
            'authors/suzuki.jpg',
            'authors/tolle.jpg',
            'authors/watts.jpg',
        ];

        return [
            'name'  => $this->faker->name(),
            'slug'  => Str::slug($this->faker->unique()->name()),
            'photo' => $this->faker->randomElement($photos),
            'bio'   => $this->faker->realTextBetween(300, 600),
        ];
    }
}
