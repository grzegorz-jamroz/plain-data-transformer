<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;
use PlainDataTransformerTests\Variant\SampleBackedEnum;
use PlainDataTransformerTests\Variant\SampleBackedIntEnum;
use PlainDataTransformerTests\Variant\SampleOne;
use PlainDataTransformerTests\Variant\SamplePureEnum;
use PlainDataTransformerTests\Variant\SampleTwo;

class ToStringTest extends TestCase
{
    public function testShouldReturnEmptyString(): void
    {
        $this->assertSame('', Transform::toString(null));
        $this->assertSame('', Transform::toString(''));
        $this->assertSame('', Transform::toString(['foo' => 'bar']));
        $this->assertSame('', Transform::toString([]));
        $this->assertSame('', Transform::toString(new SampleTwo()));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertSame('', Transform::toString($callable));
    }

    public function testShouldReturnOriginalStrings(): void
    {
        $this->assertSame('something', Transform::toString('something'));
        $this->assertSame('true', Transform::toString('true'));
        $this->assertSame('false', Transform::toString('false'));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertSame('', Transform::toString(new Sample()));
        $this->assertSame('sample', Transform::toString(new SampleOne()));
        $this->assertSame('ACTIVE', Transform::toString(SamplePureEnum::ACTIVE));
        $this->assertSame('type_a', Transform::toString(SampleBackedEnum::TYPE_A));
        $this->assertSame('1', Transform::toString(SampleBackedIntEnum::TYPE_ONE));
        $this->assertSame('0.1', Transform::toString(0.1));
        $this->assertSame('1', Transform::toString(1));
        $this->assertSame('true', Transform::toString(true));
        $this->assertSame('false', Transform::toString(false));
    }
}
