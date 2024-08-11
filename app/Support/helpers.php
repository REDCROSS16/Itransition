<?php

if (!function_exists('arrayGenerator')) {
    function arrayGenerator(array $array): Generator
    {
        foreach ($array as $item) {
            yield $item;
        }
    }
}

if (!function_exists('toFloat')) {
    function toFloat(int|float|string|null $value): float
    {
        if (\is_string($value)) {
            $value = preg_replace(['~(?![\d.,-]).~', '~,~'], ['', '.'], $value);
        }

        return (float) $value;
    }
}

if (!function_exists('toInt')) {
    function toInt(string|int|float|bool|null $value): int
    {
        if (\is_string($value)) {
            $value = preg_replace(['~(?![\d.,-]).~', '~,~'], ['', '.'], $value);
        }

        return (int) $value;
    }
}
