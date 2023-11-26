<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\TransformNumeric;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\TransformNumeric;

class ToFloatTest extends TestCase
{
    public function testShouldReturnZero(): void
    {
        $this->assertEquals(0, TransformNumeric::toFloat(0));
        $this->assertEquals(0, TransformNumeric::toFloat(0, 1));
        $this->assertEquals(0, TransformNumeric::toFloat(0, 2));
        $this->assertEquals(0, TransformNumeric::toFloat(0, 3));
    }

    public function testShouldReturnExpectedFloat(): void
    {
        $this->assertEquals(3, TransformNumeric::toFloat(3));
        $this->assertEquals(3, TransformNumeric::toFloat(3, -1));
        $this->assertEquals(3, TransformNumeric::toFloat(3, -2));
        $this->assertEquals(3.45, TransformNumeric::toFloat(345, 2));
        $this->assertEquals(0.07, TransformNumeric::toFloat(7, 2));
        $this->assertEquals(10076.25678, TransformNumeric::toFloat(1007625678, 5));
        $this->assertEquals(2200076.25, TransformNumeric::toFloat(220007625, 2));
        $this->assertEquals(24, TransformNumeric::toFloat(24000, 3));
        $this->assertEquals(-3.45, TransformNumeric::toFloat(-345, 2));
        $this->assertEquals(-24, TransformNumeric::toFloat(-24000, 3));
    }
}
