<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Variant;

class SampleOne implements \JsonSerializable
{
    public function __toString(): string
    {
        return 'sample';
    }

    public function jsonSerialize(): array {
        throw new \Exception('sample exception');
    }
}
