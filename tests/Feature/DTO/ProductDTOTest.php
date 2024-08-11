<?php declare(strict_types=1);

namespace Tests\Feature\DTO;

use App\DTO\ProductDTO;
use Monolog\Test\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProductDTOTest extends TestCase
{
    private const CODE = 'POOO1';
    private const NAME = 'test';
    private const DESC = 'test';
    private const STOCK = 10;
    private const PRICE = 10000;

    private const VALUES = [
        self::CODE,
        self::NAME,
        self::DESC,
        self::STOCK,
        self::PRICE,
        null,
    ];

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function test_instance_created_from_array(): void
    {
        $dto = ProductDTO::fromArray(self::VALUES);

        $this->assertInstanceOf(ProductDTO::class, $dto);
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function test_equals_array_values(): void
    {
        $dto = ProductDTO::fromArray(self::VALUES);

        $this->assertEquals(self::CODE, $dto->strProductCode);
        $this->assertEquals(self::NAME, $dto->strProductName);
        $this->assertEquals(self::DESC, $dto->strProductDesc);
        $this->assertEquals(self::PRICE * 100, $dto->price);
        $this->assertEquals(self::STOCK, $dto->stock);
    }
}
