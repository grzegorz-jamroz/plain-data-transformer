<?php

declare(strict_types=1);

namespace PlainDataTransformer;

interface ArrayConstructable
{
    /**
     * @param array<string, mixed> $data
     */
    public static function createFromArray(array $data): self;
}
