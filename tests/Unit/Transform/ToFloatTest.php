<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;
use PlainDataTransformerTests\Variant\SampleTwo;

class ToFloatTest extends TestCase
{
    public function testShouldReturnZero(): void
    {
        $this->assertSame(0.0, Transform::toFloat(null));
        $this->assertSame(0.0, Transform::toFloat(''));
        $this->assertSame(0.0, Transform::toFloat([]));
        $this->assertSame(0.0, Transform::toFloat(false));
        $this->assertSame(0.0, Transform::toFloat(['foo' => 'bar', 'baz' => 'qux']));
        $this->assertSame(0.0, Transform::toFloat(new Sample()));
        $this->assertSame(0.0, Transform::toFloat(new SampleTwo()));
        $this->assertSame(0.0, Transform::toFloat('0'));
        $this->assertSame(0.0, Transform::toFloat(0));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertSame(0.0, Transform::toFloat($callable));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertSame(2200076.256788332, Transform::toFloat('2 200 076.256788332'));
        $this->assertSame(2200.0, Transform::toFloat('2200'));
        $this->assertSame(5.5, Transform::toFloat('5.5'));
        $this->assertSame(5.6, Transform::toFloat('5,6'));
        $this->assertSame(5.0, Transform::toFloat('5_5'));
        $this->assertSame(5.5, Transform::toFloat(5.5));
        $this->assertSame(0.49, Transform::toFloat(0.49));
        $this->assertSame(1.0, Transform::toFloat('1'));
        $this->assertSame(1.0, Transform::toFloat(true));
        $this->assertSame(0.0, Transform::toFloat(false));
    }

    public function testShouldReturnRoundedConvertedValues(): void
    {
        $this->assertSame(400.0, Transform::toFloat('425.5677', -2));
        $this->assertSame(456.0, Transform::toFloat('455.5677', 0));
        $this->assertSame(5.6, Transform::toFloat('5.5677', 1));
        $this->assertSame(5.57, Transform::toFloat('5.5677', 2));
        $this->assertSame(5.568, Transform::toFloat('5.5677', 3));
    }
}
