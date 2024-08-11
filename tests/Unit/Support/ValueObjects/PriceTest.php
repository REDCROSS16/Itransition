<?php declare(strict_types=1);

namespace Tests\Unit\Support\ValueObjects;

use App\Support\ValueObjects\Price;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PriceTest extends TestCase
{
    /**
     * @return Price
     */
    private function price(): Price
    {
        return Price::make(10000);
    }

    /**
     * @test
     * @return void
    */
    #[Test]
    public function test_instance_of_value_object(): void
    {
        $this->assertInstanceOf(Price::class, $this->price());
    }

    /**
     * @test
     * @return void
    */
    #[Test]
    public function test_price_value_equals(): void
    {
        $this->assertEquals(100, $this->price()->value());
    }

    /**
     * @test
     * @return void
     */
    #[Test]
    public function test_price_raw_value_equals(): void
    {
        $this->assertEquals(10000, $this->price()->raw());
    }

    /**
     * @test
     * @return void
     */
    #[Test]
    public function test_price_currency_equals(): void
    {
        $this->assertEquals('GBP', $this->price()->currency());
    }

    /**
     * @test
     * @return void
     */
    public function test_price_symbol_equals(): void
    {
        $this->assertEquals('£', $this->price()->symbol());
    }

    /**
     * @test
     * @return void
     */
    public function test_price_object_call_as_string(): void
    {
        $this->assertEquals('100,00 £', $this->price());
    }

    /**
     * @test
     * @return void
    */
    public function test_price_low_than_zero(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Price::make(-10000);
    }

    /**
     * @test
     * @return void
     */
    public function test_price_invalid_currency(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Price::make(10000, 'USD');
    }
}
