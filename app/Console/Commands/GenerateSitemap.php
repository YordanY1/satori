<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Post;
use App\Models\Event;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Генерира sitemap.xml за сайта';

    public function handle(): void
    {
        $sitemaps = [];

        $static = [
            ['loc' => url('/')],
            ['loc' => url('/catalog')],
            ['loc' => url('/authors')],
            ['loc' => url('/genres')],
            ['loc' => url('/events')],
            ['loc' => url('/blog')],
            ['loc' => url('/about')],
            ['loc' => url('/contact')],
            ['loc' => url('/privacy-policy')],
            ['loc' => url('/cookie-policy')],
            ['loc' => url('/terms')],
        ];
        $this->writeSitemap('sitemap-static.xml', $static);
        $sitemaps[] = url('storage/sitemap-static.xml');

        $books = [];
        foreach (Book::select('slug', 'updated_at')->get() as $b) {
            $books[] = [
                'loc' => route('book.show', $b->slug),
                'lastmod' => optional($b->updated_at)->toAtomString(),
            ];
        }
        $this->writeSitemap('sitemap-books.xml', $books);
        $sitemaps[] = url('storage/sitemap-books.xml');

        $authors = [];
        foreach (Author::select('slug', 'updated_at')->get() as $a) {
            $authors[] = [
                'loc' => route('author.show', $a->slug),
                'lastmod' => optional($a->updated_at)->toAtomString(),
            ];
        }
        $this->writeSitemap('sitemap-authors.xml', $authors);
        $sitemaps[] = url('storage/sitemap-authors.xml');

        $genres = [];
        foreach (Genre::select('slug', 'updated_at')->get() as $g) {
            $genres[] = [
                'loc' => route('genre.show', $g->slug),
                'lastmod' => optional($g->updated_at)->toAtomString(),
            ];
        }
        $this->writeSitemap('sitemap-genres.xml', $genres);
        $sitemaps[] = url('storage/sitemap-genres.xml');

        $posts = [];
        foreach (Post::select('slug', 'updated_at')->get() as $p) {
            $posts[] = [
                'loc' => route('blog.show', $p->slug),
                'lastmod' => optional($p->updated_at)->toAtomString(),
            ];
        }
        $this->writeSitemap('sitemap-posts.xml', $posts);
        $sitemaps[] = url('storage/sitemap-posts.xml');

        $events = [];
        foreach (Event::select('slug', 'updated_at')->get() as $e) {
            $events[] = [
                'loc' => route('event.show', $e->slug),
                'lastmod' => optional($e->updated_at)->toAtomString(),
            ];
        }
        $this->writeSitemap('sitemap-events.xml', $events);
        $sitemaps[] = url('storage/sitemap-events.xml');

        $index = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($sitemaps as $s) {
            $index .= "  <sitemap><loc>{$s}</loc></sitemap>" . PHP_EOL;
        }
        $index .= '</sitemapindex>';
        Storage::disk('public')->put('sitemap.xml', $index);
    }

    private function writeSitemap(string $filename, array $urls): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        foreach ($urls as $url) {
            $xml .= "  <url>" . PHP_EOL;
            $xml .= "    <loc>" . e($url['loc']) . "</loc>" . PHP_EOL;
            if (!empty($url['lastmod'])) {
                $xml .= "    <lastmod>{$url['lastmod']}</lastmod>" . PHP_EOL;
            }
            $xml .= "  </url>" . PHP_EOL;
        }
        $xml .= '</urlset>';
        Storage::disk('public')->put($filename, $xml);
    }
}
