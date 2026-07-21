<?php

declare(strict_types=1);

namespace PlainDataTransformerTests\Variant;

enum SampleBackedEnum: string
{
    case TYPE_A = 'type_a';
    case TYPE_B = 'type_b';
    case TYPE_C = 'type_c';
}
