<?php

namespace MultiversX;

final class Bytes
{
    public function __construct(
        public readonly string $hex,
    ) {
    }

    public static function from(int|string $value): Bytes
    {
        if (is_numeric($value)) {
            return new Bytes(dechex($value));
        }

        return new Bytes(bin2hex($value));
    }
}
