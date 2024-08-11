<?php declare(strict_types=1);

namespace App\Support\ValueObjects;

use InvalidArgumentException;
use App\Support\Traits\Makeable;

final class Price implements \Stringable
{
    use Makeable;

    private array $currencies = [
        'GBP' => '£'
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'GBP',
        private readonly int $precision = 100,
    )
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Price must be more than zero');
        }

        if (!isset($this->currencies[$this->currency])) {
            throw new InvalidArgumentException('This currency didnt allowed');
        }
    }

    /**
     * @return int
     */
    public function raw(): int
    {
        return $this->value;
    }

    /**
     * @return float|int
     */
    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    /**
     * @return string
     */
    public function currency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return number_format($this->value(), 2, ',', ' ') . ' ' . $this->symbol();
    }
}
