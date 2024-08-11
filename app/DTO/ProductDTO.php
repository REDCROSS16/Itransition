<?php declare(strict_types=1);

namespace App\DTO;

use App\Support\Traits\Makeable;

class ProductDTO
{
    use Makeable;

    public function __construct(
        public readonly string $strProductCode,
        public readonly string $strProductName,
        public readonly string $strProductDesc,
        public readonly int $stock,
        public readonly int $price,
        public readonly ?\DateTime $dtmDiscontinued,
    )
    {
    }

    /**
     * @param array $values
     * @return ProductDTO
     * @throws \Exception
     */
    public static function fromArray(array $values): ProductDTO
    {   try {
            return static::make(
                $values[0],
                $values[1],
                $values[2],
                toInt($values[3]),
                toInt(toFloat($values[4]) * 100),
                $values[5] === 'yes' ? now() : null,
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
