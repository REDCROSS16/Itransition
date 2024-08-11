<?php declare(strict_types=1);

namespace Tests\Feature\Rules;

use App\DTO\ProductDTO;
use App\Support\Rules\ImportValidator;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImportRulesTest extends TestCase
{
    private const FAILED_STOCK = 9;
    private const FAILED_MIN_PRICE = 4.99;
    private const FAILED_MAX_PRICE = 1001;

    private const SUCCESS_STOCK = 11;
    private const SUCCESS_PRICE = 5.01;
    private const MOCK_TEXT = 'test';

    /**
     * @param array $array
     * @return ProductDTO
     * @throws \Exception
     */
    private function getDTO(array $array): ProductDTO
    {
        return ProductDTO::fromArray($array);
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function test_validate_failed_min_stock_and_min_price(): void
    {
        $failedValues = [
            self::MOCK_TEXT,
            self::MOCK_TEXT,
            self::MOCK_TEXT,
            self::FAILED_STOCK,
            self::FAILED_MIN_PRICE,
            null
        ];

        $this->assertFalse(ImportValidator::validate($this->getDTO($failedValues)));
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function test_validate_failed_max_price_of_items(): void
    {
        $failedValues = [
            self::MOCK_TEXT,
            self::MOCK_TEXT,
            self::MOCK_TEXT,
            self::FAILED_STOCK,
            self::FAILED_MAX_PRICE,
            null
        ];

        $this->assertFalse(ImportValidator::validate($this->getDTO($failedValues)));
    }

    /**
     * @return void
     * @throws \Exception
     */
    #[Test]
    public function test_validate_success(): void
    {
        $failedValues = [
            self::MOCK_TEXT,
            self::MOCK_TEXT,
            self::MOCK_TEXT,
            self::SUCCESS_STOCK,
            self::SUCCESS_PRICE,
            null
        ];

        $this->assertTrue(ImportValidator::validate($this->getDTO($failedValues)));
    }
}
