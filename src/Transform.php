<?php

declare(strict_types=1);

namespace PlainDataTransformer;

use Closure;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use Throwable;

final class Transform
{
    public static function toBool(mixed $value): bool
    {
        if (is_string($value) && $value === 'false') {
            return false;
        }

        return is_bool($value) ? $value : (bool) $value;
    }

    public static function toString(mixed $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (
            is_object($value)
            && method_exists($value, '__toString')
        ) {
            try {
                $value = $value->__toString();

                return is_string($value) ? $value : '';
            } catch (Throwable) {
                return '';
            }
        }

        if (
            is_float($value)
            || is_int($value)
        ) {
            return (string) $value;
        }

        return '';
    }

    public static function toInt(mixed $value): int
    {
        if (is_int($value)) {
            return $value;
        }

        if (
            is_object($value)
            && method_exists($value, '__toString')
        ) {
            try {
                $value = $value->__toString();
            } catch (Throwable) {
                return 0;
            }
        }

        if (
            is_float($value)
            || is_bool($value)
            || is_string($value)
        ) {
            return (int) $value;
        }

        return 0;
    }

    /**
     * @return array<mixed, mixed>
     */
    public static function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (
            is_float($value)
            || $value instanceof Closure
        ) {
            return [];
        }

        if (is_object($value)) {
            return (array) $value;
        }

        try {
            $value = is_string($value) ? json_decode($value, true, flags: JSON_THROW_ON_ERROR) : $value;
        } catch (Throwable) {
            return [];
        }

        return is_array($value) ? $value : [];
    }

    public static function toDateTimeImmutable(mixed $value, ?DateTimeZone $timezone = null): DateTimeImmutable
    {
        try {
            if ($value instanceof DateTimeInterface) {
                return $value instanceof DateTimeImmutable ? $value : DateTimeImmutable::createFromMutable($value);
            }

            if (
                $value === null
                || is_bool($value)
                || is_array($value)
                || is_object($value)
            ) {
                throw new Exception('Unsupported type.');
            }

            if (is_string($value)) {
                return new DateTimeImmutable($value, $timezone);
            }

            $value = self::toInt($value);

            return (new DateTimeImmutable('now', $timezone))->setTimestamp($value);
        } catch (Throwable) {
            return new DateTimeImmutable('now', $timezone);
        }
    }
}
