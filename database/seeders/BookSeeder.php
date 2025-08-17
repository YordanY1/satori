<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Genre;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        Book::factory(20)->create()->each(function ($book) {
            $book->genres()->attach(
                Genre::inRandomOrder()->take(rand(1, 3))->pluck('id')
            );
        });
    }
}
