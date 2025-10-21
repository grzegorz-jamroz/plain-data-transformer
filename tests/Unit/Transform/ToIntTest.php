<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;

class ToIntTest extends TestCase
{
    public function testShouldReturnZero(): void
    {
        $this->assertEquals(0, Transform::toInt(null));
        $this->assertEquals(0, Transform::toInt(''));
        $this->assertEquals(0, Transform::toInt([]));
        $this->assertEquals(0, Transform::toInt(['foo' => 'bar', 'baz' => 'qux']));
        $this->assertEquals(0, Transform::toInt(new Sample()));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertEquals(0, Transform::toInt($callable));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertEquals(2, Transform::toInt('2 200 076.256788332'));
        $this->assertEquals(2200, Transform::toInt('2200'));
        $this->assertEquals(5, Transform::toInt('5.5'));
        $this->assertEquals(5, Transform::toInt('5,5'));
        $this->assertEquals(5, Transform::toInt('5_5'));
        $this->assertEquals(5, Transform::toInt(5.5));
        $this->assertEquals(0, Transform::toInt(0.1));
        $this->assertEquals(0, Transform::toInt(0.49));
        $this->assertEquals(0, Transform::toInt(0.51));
        $this->assertEquals(1, Transform::toInt(1));
        $this->assertEquals(0, Transform::toInt(0));
        $this->assertEquals(1, Transform::toInt(true));
        $this->assertEquals(0, Transform::toInt(false));
    }
}
