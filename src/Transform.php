<?php

declare(strict_types=1);

namespace PlainDataTransformer;

use PlainDataTransformer\Exception\ClassNotExists;
use PlainDataTransformer\Exception\InvalidClass;

class Transform
{
    public static function toBool($value): bool
    {
        if (is_string($value) && $value === 'false') {
            return false;
        }

        try {
            return is_bool($value) ? $value : (bool) $value;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function toString($value): string
    {
        try {
            return is_string($value) ? $value : (string) $value;
        } catch (\Throwable $e) {
            return '';
        }
    }

    public static function toInt($value): int
    {
        try {
            return is_int($value) ? $value : (int) $value;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public static function toNullableString($value): ?string
    {
        return is_string($value) ? $value : null;
    }

    /**
     * @return array<mixed, mixed>
     */
    public static function toArray($value): array
    {
        return is_array($value) ? $value : [];
    }

    public static function toDateTimeImmutable($value): \DateTimeImmutable
    {
        $value = self::toInt($value);

        return (new \DateTimeImmutable())->setTimestamp($value);
    }

    /**
     * @return array<int, object>
     *
     * @throws ClassNotExists
     * @throws InvalidClass
     */
    public static function toArrayOf($values, string $className): array
    {
        if (!is_array($values)) {
            return [];
        }

        if (!class_exists($className)) {
            throw new ClassNotExists(sprintf('Required class "%s" not exists.', $className));
        }

        if (!method_exists($className, 'createFromArray')) {
            throw new InvalidClass('Method "createFromArray" not exists in the required class.');
        }

        return array_map(fn (array $value) => $className::createFromArray($value), $values);
    }

    public static function toPlainText($value): string
    {
        return strip_tags(self::toString($value));
    }
}
