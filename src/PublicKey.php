<?php

namespace MultiversX;

use MultiversX\Interfaces\IPublicKey;

final class PublicKey implements IPublicKey
{
    public function __construct(
        private readonly string $hex,
    ) {
    }

    public function getBytes(): Bytes
    {
        return new Bytes($this->hex);
    }
}
