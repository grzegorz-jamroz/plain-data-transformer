<?php

declare(strict_types=1);

namespace PlainDataTransformer;

use PlainDataTransformer\Exception\ClassNotExists;
use PlainDataTransformer\Exception\InvalidClass;

class Transform
{
    public static function toString(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    public static function toNullableString(mixed $value): ?string
    {
        return is_string($value) ? $value : null;
    }

    /**
     * @return array<mixed, mixed>
     */
    public static function toArray(mixed $value): array
    {
        return is_array($value) ? $value : [];
    }

    /**
     * @return array<int, object>
     * @throws ClassNotExists
     * @throws InvalidClass
     */
    public static function toArrayOf(mixed $values, string $className): array
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

    public static function toPlainText(mixed $value): string
    {
        return strip_tags(self::toString($value));
    }
}
