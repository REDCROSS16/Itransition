<?php declare(strict_types=1);

namespace Tests\Feature\Models\Casts;

use App\Models\Product;
use App\Support\ValueObjects\Price;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PriceCastTest extends TestCase
{
    use RefreshDatabase;

    private const TABLE = 'tblProductData';

    /**
     * @return void
     */
    private function createModel(): void
    {
        $product = ProductFactory::new()->create([
            'strProductCode' => 'P0001',
            'price'          => 10000,
        ]);

        $product->save();
    }

    /**
     * @return Model
     */
    private function getModel(): Model
    {
        return Product::query()->where([
            'strProductCode' =>'P0001'
        ])->first();
    }

    /**
     * @test
     * @return void
    */
    #[Test]
    public function test_model_set_right_instance(): void
    {
        $this->assertDatabaseMissing(self::TABLE, [
            'strProductCode' => 'P0001'
        ]);

        $this->createModel();

        $this->assertDatabaseHas(self::TABLE, [
            'strProductCode' => 'P0001'
        ]);

        $product = $this->getModel();

        $this->assertInstanceOf(Price::class, $product->price);
    }

    /**
     * @test
     * @return void
    */
    #[Test]
    public function test_model_get_right_raw_value(): void
    {
        $this->assertDatabaseMissing(self::TABLE, [
            'strProductCode' => 'P0001'
        ]);

        $this->createModel();

        $this->assertDatabaseHas(self::TABLE, [
            'strProductCode' => 'P0001'
        ]);

        $product = $this->getModel();

        $this->assertEquals(10000, $product->price->raw());
    }
}
