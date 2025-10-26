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
        $this->assertEquals([], Transform::toArray(null));
        $this->assertEquals([], Transform::toArray(''));
        $this->assertEquals([], Transform::toArray([]));
        $this->assertEquals([], Transform::toArray(new Sample()));
        $this->assertEquals([], Transform::toArray(new SampleOne()));
        $this->assertEquals([], Transform::toArray('something'));
        $this->assertEquals([], Transform::toArray('[]'));
        $this->assertEquals([], Transform::toArray('{}'));
        $this->assertEquals([], Transform::toArray('{'));
        $this->assertEquals([], Transform::toArray('{["one", "two"], "foo": "bar"}'));
        $this->assertEquals([], Transform::toArray(0.1));
        $this->assertEquals([], Transform::toArray(1));
        $this->assertEquals([], Transform::toArray(true));
        $this->assertEquals([], Transform::toArray(false));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertEquals([], Transform::toArray($callable));
    }

    public function testShouldReturnOriginalArrays(): void
    {
        $this->assertEquals(['foo' => 'bar'], Transform::toArray(['foo' => 'bar']));
    }

    public function testShouldReturnConvertedValues(): void
    {
        $this->assertEquals(['foo' => 'xyz', 'bar' => 123], Transform::toArray(new SampleTwo('xyz', 123)));
        $this->assertEquals(['one', 'two'], Transform::toArray('["one", "two"]'));
        $this->assertEquals(
            ['items' => ['one', 'two'], 'foo' => 'bar'],
            Transform::toArray('{"items": ["one", "two"], "foo": "bar"}')
        );
    }
}
