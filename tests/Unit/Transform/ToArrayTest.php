<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;
use PlainDataTransformerTests\Variant\SampleOne;
use PlainDataTransformerTests\Variant\SampleTwo;

class ToArrayTest extends TestCase
{
    public function testShouldReturnEmptyArray(): void
    {
        $this->assertSame([], Transform::toArray(null));
        $this->assertSame([], Transform::toArray(''));
        $this->assertSame([], Transform::toArray([]));
        $this->assertSame([], Transform::toArray(new Sample()));
        $this->assertSame([], Transform::toArray(new SampleOne()));
        $this->assertSame([], Transform::toArray('something'));
        $this->assertSame([], Transform::toArray('[]'));
        $this->assertSame([], Transform::toArray('{}'));
        $this->assertSame([], Transform::toArray('{'));
        $this->assertSame([], Transform::toArray('{["one", "two"], "foo": "bar"}'));
        $this->assertSame([], Transform::toArray(0.1));
        $this->assertSame([], Transform::toArray(1));
        $this->assertSame([], Transform::toArray(true));
        $this->assertSame([], Transform::toArray(false));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertSame([], Transform::toArray($callable));
    }

    public function testShouldReturnOriginalArrays(): void
    {
        $this->assertSame(['foo' => 'bar'], Transform::toArray(['foo' => 'bar']));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertSame(['foo' => 'xyz', 'bar' => 123], Transform::toArray(new SampleTwo('xyz', 123)));
        $this->assertSame(['one', 'two'], Transform::toArray('["one", "two"]'));
        $this->assertSame(
            ['items' => ['one', 'two'], 'foo' => 'bar'],
            Transform::toArray('{"items": ["one", "two"], "foo": "bar"}')
        );
    }
}
