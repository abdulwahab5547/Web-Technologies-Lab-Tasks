<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SeedProductImages extends Command
{
    protected $signature = 'products:seed-images {--force : Re-download even if product already has an image}';
    protected $description = 'Download relevant stock images from loremflickr and attach them to products';

    /**
     * Map a product to a keyword for the image search. Order matters —
     * first match wins.
     */
    private array $keywordMap = [
        'headphone'  => 'headphones',
        'keyboard'   => 'mechanical-keyboard',
        'monitor'    => 'monitor-desk',
        'speaker'    => 'bluetooth-speaker',
        'smart home' => 'smart-home',

        'oxford'     => 'oxford-shirt',
        'chino'      => 'chinos',
        'sweater'    => 'wool-sweater',
        'jacket'     => 'jacket',
        'tee'        => 'white-tshirt',

        'atomic habits'    => 'book',
        'design of'        => 'design-book',
        'sapiens'          => 'history-book',
        'deep work'        => 'reading-book',
        'pragmatic'        => 'programming-book',

        'coffee'     => 'pour-over-coffee',
        'cutting'    => 'cutting-board',
        'blanket'    => 'throw-blanket',
        'dutch oven' => 'dutch-oven',
        'succulent'  => 'succulents',
    ];

    public function handle(): int
    {
        $products = Product::all();
        $force    = $this->option('force');

        $this->info("Found {$products->count()} products. Starting image download…");
        $this->newLine();

        $ok = $skip = $fail = 0;

        foreach ($products as $product) {
            if ($product->image_path && !$force) {
                $this->line("  <fg=gray>skip</>  {$product->name} — already has image");
                $skip++;
                continue;
            }

            $keyword = $this->keywordFor($product->name);
            $url     = "https://loremflickr.com/800/800/{$keyword}";

            try {
                $response = Http::timeout(20)->withOptions(['allow_redirects' => true])->get($url);

                if (!$response->successful() || strlen($response->body()) < 5000) {
                    throw new \RuntimeException("bad response (HTTP {$response->status()}, size " . strlen($response->body()) . ')');
                }

                $filename = "products/{$product->slug}.jpg";
                Storage::disk('public')->put($filename, $response->body());

                // Delete the old image if we're replacing it
                if ($force && $product->image_path && $product->image_path !== $filename) {
                    Storage::disk('public')->delete($product->image_path);
                }

                $product->update(['image_path' => $filename]);

                $this->line("  <fg=green>ok</>    {$product->name} <fg=gray>[{$keyword}]</>");
                $ok++;
            } catch (\Throwable $e) {
                $this->line("  <fg=red>fail</>  {$product->name} — {$e->getMessage()}");
                $fail++;
            }
        }

        $this->newLine();
        $this->info("Done. {$ok} downloaded, {$skip} skipped, {$fail} failed.");

        return self::SUCCESS;
    }

    private function keywordFor(string $productName): string
    {
        $lower = strtolower($productName);

        foreach ($this->keywordMap as $needle => $keyword) {
            if (str_contains($lower, $needle)) {
                return $keyword;
            }
        }

        return 'product';
    }
}
