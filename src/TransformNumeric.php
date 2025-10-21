<?php

declare(strict_types=1);

namespace PlainDataTransformer;

final class TransformNumeric
{
    public static function toInt(string|float|int $value, int $precision = 0): int
    {
        $value = Transform::toString($value);
        $value = str_replace(',', '.', $value);
        $value = str_replace(["\xc2\xa0", ' '], '', $value);

        return Transform::toInt((float) $value * self::getPrecisionValue($precision));
    }

    public static function toFloat(int $value, int $precision = 0): float
    {
        return $value / self::getPrecisionValue($precision);
    }

    private static function getPrecisionValue(int $precision = 0): int
    {
        return $precision > 0 ? array_reduce(range(0, $precision - 1), fn (int $acc, int $p) => $acc * 10, 1) : 1;
    }
}
