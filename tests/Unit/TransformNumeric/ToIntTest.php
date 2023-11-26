<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\TransformNumeric;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\TransformNumeric;
use PlainDataTransformerTests\Variant\Sample;

class ToIntTest extends TestCase
{
    public function testShouldReturnZeroWithoutPrecision(): void
    {
        // When & Then
        $this->assertEquals(0, TransformNumeric::toInt(0));
        $this->assertEquals(0, TransformNumeric::toInt('0'));
        $this->assertEquals(0, TransformNumeric::toInt(0.000));
        $this->assertEquals(0, TransformNumeric::toInt('0.000'));
        $this->assertEquals(0, TransformNumeric::toInt(00.000));
        $this->assertEquals(0, TransformNumeric::toInt('00.000'));
        $this->assertEquals(0, TransformNumeric::toInt('0,000'));
        $this->assertEquals(0, TransformNumeric::toInt('00,000'));
        $this->assertEquals(0, TransformNumeric::toInt('abcd'));
    }

    public function testShouldReturnZero(): void
    {
        // When & Then
        $this->assertEquals(0, TransformNumeric::toInt(0));
        $this->assertEquals(0, TransformNumeric::toInt(0, 1));
        $this->assertEquals(0, TransformNumeric::toInt(0, 2));
        $this->assertEquals(0, TransformNumeric::toInt(0, 3));
        $this->assertEquals(0, TransformNumeric::toInt(0, 4));
        $this->assertEquals(0, TransformNumeric::toInt(0, 5));
        $this->assertEquals(0, TransformNumeric::toInt(0.0, 5));
        $this->assertEquals(0, TransformNumeric::toInt(0.000, 5));
        $this->assertEquals(0, TransformNumeric::toInt('abcd', 5));
        $this->assertEquals(0, TransformNumeric::toInt(0, -1));
        $this->assertEquals(0, TransformNumeric::toInt('00,000', -2));
    }

    public function testShouldReturnExpectedInteger(): void
    {
        // When & Then
        $this->assertEquals(3, TransformNumeric::toInt(3.45));
        $this->assertEquals(3, TransformNumeric::toInt('3.45'));
        $this->assertEquals(3, TransformNumeric::toInt(3.45, -1));
        $this->assertEquals(3, TransformNumeric::toInt(3.45, -2));
        $this->assertEquals(345, TransformNumeric::toInt(3.45, 2));
        $this->assertEquals(345, TransformNumeric::toInt('3.45', 2));
        $this->assertEquals(-345, TransformNumeric::toInt('-3.45', 2));
        $this->assertEquals(7, TransformNumeric::toInt(0.076, 2));
        $this->assertEquals(1007625678, TransformNumeric::toInt('10 076,256788332', 5));
        $this->assertEquals(1007625678, TransformNumeric::toInt('10 076.256788332', 5));
        $this->assertEquals(220007625, TransformNumeric::toInt('2 200 076.256788332', 2));
        $this->assertEquals(24000, TransformNumeric::toInt(24, 3));
        $this->assertEquals(-24000, TransformNumeric::toInt(-24, 3));
    }

    public function testShouldThrowInvalidArgumentExceptionForInvalidValueType()
    {
        // Given
        $values = [
            true,
            false,
            null,
            [],
            new Sample()
        ];

        // When & Then
        foreach ($values as $value) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Expected string, float or int.');
            TransformNumeric::toInt($value);
        }
    }
}
