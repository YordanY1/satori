<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Book;
use App\Models\Event;
use App\Models\Genre;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Генерира sitemap.xml и известява търсачките';

    public function handle(): void
    {
        $this->info('🔄 Генериране на sitemap файловете...');

        $sitemaps = [];

        // --- Static pages ---
        $static = collect([
            '/',
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
        ])->map(fn ($path) => ['loc' => url($path)]);

        $this->writeSitemap('sitemap-static.xml', $static);
        $sitemaps[] = url('sitemap-static.xml');

        // --- Dynamic sections ---
        $this->generateSection(Book::class, 'book.show', 'sitemap-books.xml', $sitemaps);
        $this->generateSection(Author::class, 'author.show', 'sitemap-authors.xml', $sitemaps);
        $this->generateSection(Genre::class, 'genre.show', 'sitemap-genres.xml', $sitemaps);
        $this->generateSection(Post::class, 'blog.show', 'sitemap-posts.xml', $sitemaps);
        $this->generateSection(Event::class, 'event.show', 'sitemap-events.xml', $sitemaps);

        // --- Sitemap index ---
        $index = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $index .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
        foreach ($sitemaps as $s) {
            $index .= "  <sitemap><loc>{$s}</loc></sitemap>".PHP_EOL;
        }
        $index .= '</sitemapindex>';

        file_put_contents(public_path('sitemap.xml'), $index);

        // 🔁 Автоматично копиране в public_html (Jump.bg)
        $this->copyToPublicHtml('sitemap.xml');
        $this->copyToPublicHtml('sitemap-static.xml');
        $this->copyToPublicHtml('sitemap-books.xml');
        $this->copyToPublicHtml('sitemap-authors.xml');
        $this->copyToPublicHtml('sitemap-genres.xml');
        $this->copyToPublicHtml('sitemap-posts.xml');
        $this->copyToPublicHtml('sitemap-events.xml');

        $this->info('✅ Sitemap файловете са обновени и копирани.');

        // Ping engines
        $this->pingSearchEngines(url('sitemap.xml'));
    }

    private function generateSection(string $model, string $route, string $filename, array &$sitemaps): void
    {
        $urls = [];
        foreach ($model::select('slug', 'updated_at')->get() as $item) {
            $urls[] = [
                'loc' => route($route, $item->slug),
                'lastmod' => optional($item->updated_at)->toAtomString(),
            ];
        }

        $this->writeSitemap($filename, $urls);
        $sitemaps[] = url($filename);
    }

    private function writeSitemap(string $filename, iterable $urls): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        foreach ($urls as $url) {
            $xml .= '  <url>'.PHP_EOL;
            $xml .= '    <loc>'.e($url['loc']).'</loc>'.PHP_EOL;
            if (! empty($url['lastmod'])) {
                $xml .= "    <lastmod>{$url['lastmod']}</lastmod>".PHP_EOL;
            }
            $xml .= '  </url>'.PHP_EOL;
        }

        $xml .= '</urlset>';
        file_put_contents(public_path($filename), $xml);
    }

    private function copyToPublicHtml(string $filename): void
    {
        $source = public_path($filename);
        $destination = base_path('../public_html/'.$filename);

        if (file_exists($source)) {
            copy($source, $destination);
            $this->line("📂 Копиран: {$filename}");
        } else {
            $this->warn("⚠️ Пропуснат (не е намерен): {$filename}");
        }
    }

    private function pingSearchEngines(string $sitemapUrl): void
    {
        $this->info('📡 Известяване на търсачките...');

        $engines = [
            'Google' => "https://www.google.com/ping?sitemap={$sitemapUrl}",
            'Bing' => "https://www.bing.com/ping?sitemap={$sitemapUrl}",
        ];

        foreach ($engines as $name => $url) {
            try {
                $response = Http::timeout(5)->get($url);
                if ($response->successful()) {
                    $this->info("✅ {$name} беше известен успешно.");
                } else {
                    $this->warn("⚠️ {$name} върна грешка ({$response->status()}).");
                }
            } catch (\Throwable $e) {
                $this->error("❌ Грешка при пинг към {$name}: ".$e->getMessage());
            }
        }
    }
}
