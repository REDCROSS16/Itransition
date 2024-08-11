<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Support\Rules\ImportValidator;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use function arrayGenerator;

class ImportCsvCommand extends Command
{
    protected $signature = 'app:import {path} {--test} {--storage=files}';
    protected $description = 'Command description';

    private int $passed = 0;
    private int $failed = 0;
    private Collection $failedProducts;

    /**
     * @return int
     */
    public function handle(): int
    {
        $this->failedProducts = collect();
        $path = $this->argument('path');
        if  (Storage::disk($this->option('storage'))->exists($path)) {
            $lines = explode(PHP_EOL, Storage::disk($this->option('storage'))->get($path));

            array_shift($lines);
            array_pop($lines);

            $bar = $this->output->createProgressBar(count($lines));
            $bar->start();

            foreach (arrayGenerator($lines) as $line) {
                $bar->advance();
                $properties = explode(',', $line);
                try {
                    $product = ProductDTO::fromArray($properties);

                    (ImportValidator::validate($product))
                        ? $this->updateOrCreate($product)
                        : $this->collectFailedProducts($product);

                } catch (\Exception) {
                    $this->collectFailedProducts($properties);
                }
            };

            $bar->finish();
            $this->newLine();

            $this->table(['Passed', 'Skipped'],
                [
                    [
                        $this->passed,
                        $this->failed
                    ]
                ]
            );

            $this->table(['ProductCode', 'Status'],
                $this->getFailedProducts()
            );

            return self::SUCCESS;
        }

        return self::FAILURE;
    }

    /**
     * @param ProductDTO $product
     * @return void
     */
    private function updateOrCreate(ProductDTO $product): void
    {
        if (!$this->option('test')) {
            Product::query()->updateOrCreate([
                'strProductCode'  => $product->strProductCode,
            ], [
                'strProductName'  => $product->strProductName,
                'strProductDesc'  => $product->strProductDesc,
                'stock'           => $product->stock,
                'price'           => $product->price,
                'dtmAdded'        => now(),
                'dtmDiscontinued' => $product->dtmDiscontinued,
            ]);
        }

        $this->passed++;
    }

    /**
     * @param array|ProductDTO $product
     * @return void
     */
    private function collectFailedProducts(array|ProductDTO $product): void
    {
        $this->failedProducts->push($product);
        $this->failed++;
    }

    /**
     * @return array
     */
    private function getFailedProducts(): array
    {
        $failed = [];

        foreach ($this->failedProducts as $product) {
            if ($product->strProductCode ?? $product[0]) {
                $failed [] = [
                    'productCode' => $product->strProductCode ?? $product[0],
                    'status'      => 'skipped',
                ];
            }
        }

        return $failed;
    }
}
