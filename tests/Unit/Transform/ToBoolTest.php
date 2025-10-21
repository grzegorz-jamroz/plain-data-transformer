<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Unit\Transform;

use PHPUnit\Framework\TestCase;
use PlainDataTransformer\Transform;
use PlainDataTransformerTests\Variant\Sample;

class ToBoolTest extends TestCase
{
    public function testShouldReturnFalse(): void
    {
        $this->assertFalse(Transform::toBool(null));
        $this->assertFalse(Transform::toBool('false'));
        $this->assertFalse(Transform::toBool(''));
        $this->assertFalse(Transform::toBool(false));
        $this->assertFalse(Transform::toBool(0));
        $this->assertFalse(Transform::toBool(0.0));
        $this->assertFalse(Transform::toBool([]));
    }

    public function testShouldReturnTrue(): void
    {
        $this->assertTrue(Transform::toBool(new Sample()));
        $this->assertTrue(Transform::toBool(0.1));
        $this->assertTrue(Transform::toBool(1));
        $this->assertTrue(Transform::toBool('true'));
        $this->assertTrue(Transform::toBool(true));
        $this->assertTrue(Transform::toBool(['foo' => 'bar']));
        $callable = function() {
            throw new \Exception('sample exception');
        };
        $this->assertTrue(Transform::toBool($callable));
    }
}
