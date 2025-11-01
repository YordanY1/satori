<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class SyncBookGenres extends Command
{
    protected $signature = 'sync:book-genres';

    protected $description = 'Add book.genre_id to pivot table without removing existing genres';

    public function handle()
    {
        $this->info('Syncing book genres without deleting anything...');

        $count = 0;

        Book::whereNotNull('genre_id')->chunk(200, function ($books) use (&$count) {
            foreach ($books as $book) {
                $book->genres()->syncWithoutDetaching([$book->genre_id]);
                $count++;
            }
        });

        $this->info("Done. Updated {$count} books. No data was removed.");

        return Command::SUCCESS;
    }
}
