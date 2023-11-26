<?php

declare(strict_types=1);

namespace PlainDataTransformer;

class TransformNumeric
{
    /**
     * @param string|float|int $value
     */
    public static function toInt($value, int $precision = 0): int
    {
        $isValid = is_string($value) || is_float($value) || is_int($value);

        if ($isValid === false) {
            throw new \InvalidArgumentException('Expected string, float or int.');
        }

        $value = Transform::toString($value);
        $value = str_replace(',', '.', $value);
        $value = str_replace(["\xc2\xa0", ' '], '', $value);

        return Transform::toInt((float) $value * static::getPrecisionValue($precision));
    }

    public static function toFloat(int $value, int $precision = 0): float
    {
        return $value / static::getPrecisionValue($precision);
    }

    private static function getPrecisionValue(int $precision = 0): int
    {
        return $precision > 0 ? array_reduce(range(0, $precision - 1), fn (int $acc, int $p) => $acc * 10, 1) : 1;
    }
}
