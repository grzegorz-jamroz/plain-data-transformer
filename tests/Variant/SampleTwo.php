<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Variant;

class SampleTwo implements \JsonSerializable
{
    public function __construct(
        public string $foo = '',
        public int $bar = 0,
    )
    {
    }

    public function __toString(): string
    {
        throw new \Exception('sample exception');
    }

    public function jsonSerialize(): array
    {
        return [
            'foo' => $this->foo,
            'bar' => $this->bar,
        ];
    }
}
