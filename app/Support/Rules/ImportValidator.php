<?php declare(strict_types=1);

namespace App\Support\Rules;

use App\DTO\ProductDTO;

class ImportValidator
{
    /**
     * @param ProductDTO $productDTO
     * @return bool
     */
    public static function validate(ProductDTO $productDTO): bool
    {
        return match (true) {
            // Any stock item which costs less that $5 and has less than 10 stock will not be imported.
            $productDTO->stock < ImportRules::MIN_STOCK && $productDTO->price < ImportRules::MIN_PRICE,
            // Any stock items which cost over $1000 will not be imported.
            $productDTO->price * $productDTO->stock > ImportRules::MAX_PRICE => false,
            // or $productDTO->price < ImportRules::MAX_PRICE => false,
            default => true,
        };
    }
}
