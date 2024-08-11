<?php declare(strict_types=1);

namespace App\Support\Casts;

use App\Support\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PriceCast implements CastsAttributes
{
    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Price
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): Price
    {
        return Price::make($value);
    }

    /**
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return int
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        if (!$value instanceof Price) {
            $value = Price::make($value);
        }

        return $value->raw();
    }
}
