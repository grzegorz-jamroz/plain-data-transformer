<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;

class ToDateTimeImmutableTest extends TestCase
{
    #[DataProvider('currentDateTimeProvider')]
    public function testShouldReturnCurrentDateTimeImmutable(mixed $value): void
    {
        $dateTime = Transform::toDateTimeImmutable($value);
        $now = (new DateTimeImmutable())->getTimestamp();
        $timestamp = $dateTime->getTimestamp();
        $this->assertGreaterThan($now - 1, $timestamp);
        $this->assertLessThan($now + 1, $timestamp);
        $this->assertInstanceOf(DateTimeImmutable::class, $dateTime);
    }

    public static function currentDateTimeProvider(): \Generator
    {
        yield 'value is null' => [null];
        yield 'value is empty string' => [''];
        yield 'value is not DateTime string' => ['something'];
        yield 'value is true' => [true];
        yield 'value is false' => [false];
        yield 'value is empty array' => [[]];
        yield 'value is associative array' => [['foo' => 'bar']];
        yield 'value is object' => [new Sample()];
        $callable = function() {
            throw new \Exception('sample exception');
        };
        yield 'value is callable' => [$callable];
    }

    #[DataProvider('dateTimeInSpecificTimeZoneProvider')]
    public function testShouldReturnDateTimeInSpecificTimeZone(mixed $value, DateTimeZone $timeZone, DateTimeZone $expectedTimeZone): void
    {
        $dateTime = Transform::toDateTimeImmutable($value, $timeZone);
        $this->assertEquals($expectedTimeZone, $dateTime->getTimezone());
        $this->assertEquals(1410273901, $dateTime->getTimestamp());
        $this->assertEquals('2014-09-09T16:45:01+02:00', $dateTime->format(DateTimeImmutable::ATOM));
        $this->assertInstanceOf(DateTimeImmutable::class, $dateTime);
    }

    public static function dateTimeInSpecificTimeZoneProvider(): \Generator
    {
        yield 'value is in Y-m-d H:i:s format' => ['2014-09-09 16:45:01', new DateTimeZone('Europe/Warsaw'), new DateTimeZone('Europe/Warsaw')];
        yield 'value is in ATOM format' => ['2014-09-09T16:45:01+02:00', new \DateTimeZone('Europe/Athens'), new DateTimeZone('+02:00')];
        yield 'value is timestamp' => [1410273901, new DateTimeZone('Europe/Warsaw'), new \DateTimeZone('Europe/Warsaw')];
    }

    #[DataProvider('convertedValuesProvider')]
    public function testShouldReturnConvertedValues(mixed $value, DateTimeImmutable $expected): void
    {
        $this->assertEquals($expected, Transform::toDateTimeImmutable($value));
    }

    public static function convertedValuesProvider(): \Generator
    {
        yield 'value is integer 0' => [0, new DateTimeImmutable()->setTimestamp(0)];
        yield 'value is float 0.49' => [0.49, new DateTimeImmutable()->setTimestamp(0)];
        yield 'value is float 0.51' => [0.51, new DateTimeImmutable()->setTimestamp(0)];
        yield 'value is float 5.51' => [5.51, new DateTimeImmutable()->setTimestamp(5)];
        yield 'value is integer / timestamp' => [1625077800, new DateTimeImmutable()->setTimestamp(1625077800)];
        yield 'value is string in Y-m-d H:i:s format' => ['2014-09-09 16:45:01', new DateTimeImmutable('2014-09-09 16:45:01')];
        yield 'value is string in ATOM format' => ['2014-09-09T16:45:01+02:00', new DateTimeImmutable('2014-09-09T16:45:01+02:00')];
        yield 'value is string in Y-m-d' => ['2014-09-09', new DateTimeImmutable('2014-09-09')];
        yield 'value is DateTime object' => [new DateTime('2014-09-09 16:45:01'), new DateTimeImmutable('2014-09-09 16:45:01')];
        yield 'value is DateTimeImmutable object' => [new DateTimeImmutable('2014-09-09 16:45:01'), new DateTimeImmutable('2014-09-09 16:45:01')];
    }

}
