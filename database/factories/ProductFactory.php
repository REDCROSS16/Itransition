<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'strProductCode'  => ucfirst($this->faker->words(2, true)),
            'strProductName'  => ucfirst($this->faker->words(2, true)),
            'strProductDesc'  => $this->faker->realText(),
            'stock'           => $this->faker->numberBetween(1, 100),
            'price'           => $this->faker->numberBetween(100, 10000),
            'dtmAdded'        => now(),
            'dtmDiscontinued' => null,
        ];
    }
}
