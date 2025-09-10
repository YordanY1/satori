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
        $urls = [];


        $urls[] = ['loc' => url('/')];


        foreach (
            [
                '/catalog',
                '/authors',
                '/genres',
                '/events',
                '/blog',
                '/about',
                '/contact',
                '/privacy-policy',
                '/cookie-policy',
                '/terms',
            ] as $path
        ) {
            $urls[] = ['loc' => url($path)];
        }


        foreach (Book::select('slug', 'updated_at')->get() as $b) {
            $urls[] = [
                'loc' => route('book.show', $b->slug),
                'lastmod' => optional($b->updated_at)->toAtomString(),
            ];
        }

        foreach (Author::select('slug', 'updated_at')->get() as $a) {
            $urls[] = [
                'loc' => route('author.show', $a->slug),
                'lastmod' => optional($a->updated_at)->toAtomString(),
            ];
        }

        foreach (Genre::select('slug', 'updated_at')->get() as $g) {
            $urls[] = [
                'loc' => route('genre.show', $g->slug),
                'lastmod' => optional($g->updated_at)->toAtomString(),
            ];
        }

        foreach (Post::select('slug', 'updated_at')->get() as $p) {
            $urls[] = [
                'loc' => route('blog.show', $p->slug),
                'lastmod' => optional($p->updated_at)->toAtomString(),
            ];
        }

        foreach (Event::select('slug', 'updated_at')->get() as $e) {
            $urls[] = [
                'loc' => route('event.show', $e->slug),
                'lastmod' => optional($e->updated_at)->toAtomString(),
            ];
        }

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

        Storage::disk('public')->put('sitemap.xml', $xml);

        $this->info('✅ Sitemap generated successfully!');
    }
}
