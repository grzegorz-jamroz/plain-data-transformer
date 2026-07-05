<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;
use PlainDataTransformerTests\Variant\SampleTwo;

class ToIntTest extends TestCase
{
    public function testShouldReturnZero(): void
    {
        $this->assertSame(0, Transform::toInt(null));
        $this->assertSame(0, Transform::toInt(''));
        $this->assertSame(0, Transform::toInt([]));
        $this->assertSame(0, Transform::toInt(['foo' => 'bar', 'baz' => 'qux']));
        $this->assertSame(0, Transform::toInt(new Sample()));
        $this->assertSame(0, Transform::toInt(new SampleTwo()));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertSame(0, Transform::toInt($callable));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertSame(2200076, Transform::toInt('2 200 076.256788332'));
        $this->assertSame(2200, Transform::toInt('2200'));
        $this->assertSame(5, Transform::toInt('5.5'));
        $this->assertSame(5, Transform::toInt('5,5'));
        $this->assertSame(5, Transform::toInt('5_5'));
        $this->assertSame(5, Transform::toInt(5.5));
        $this->assertSame(0, Transform::toInt(0.1));
        $this->assertSame(0, Transform::toInt(0.49));
        $this->assertSame(0, Transform::toInt(0.51));
        $this->assertSame(1, Transform::toInt(1));
        $this->assertSame(0, Transform::toInt(0));
        $this->assertSame(1, Transform::toInt(true));
        $this->assertSame(0, Transform::toInt(false));
    }
}
