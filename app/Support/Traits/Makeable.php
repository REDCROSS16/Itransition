<?php declare(strict_types=1);

namespace App\Support\Traits;

trait Makeable
{
    //  mixed ...$arguments - распаковка extract
    public static function make(mixed ...$arguments): self
    {
        // тут тоже распаковываются аргументы
        return new static(...$arguments);
    }
}
