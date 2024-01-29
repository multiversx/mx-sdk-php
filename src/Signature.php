<?php

namespace MultiversX;

class Signature
{
    public function __construct(
        private string $valueHex,
    ) {
    }

    public function hex(): string
    {
        return $this->valueHex;
    }
}
