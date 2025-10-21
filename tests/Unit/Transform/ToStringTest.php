<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;
use PlainDataTransformerTests\Variant\SampleOne;
use PlainDataTransformerTests\Variant\SampleTwo;

class ToStringTest extends TestCase
{
    public function testShouldReturnEmptyString(): void
    {
        $this->assertEquals('', Transform::toString(null));
        $this->assertEquals('', Transform::toString(''));
        $this->assertEquals('', Transform::toString(['foo' => 'bar']));
        $this->assertEquals('', Transform::toString([]));
        $this->assertEquals('', Transform::toString(new SampleTwo()));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertEquals('', Transform::toString($callable));
    }

    public function testShouldReturnOriginalStrings(): void
    {
        $this->assertEquals('something', Transform::toString('something'));
        $this->assertEquals('true', Transform::toString('true'));
        $this->assertEquals('false', Transform::toString('false'));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertEquals('', Transform::toString(new Sample()));
        $this->assertEquals('sample', Transform::toString(new SampleOne()));
        $this->assertEquals('0.1', Transform::toString(0.1));
        $this->assertEquals('1', Transform::toString(1));
        $this->assertEquals('true', Transform::toString(true));
        $this->assertEquals('false', Transform::toString(false));
    }
}
