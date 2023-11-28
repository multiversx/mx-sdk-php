<?php

namespace MultiversX\Interfaces;

use MultiversX\Signature;

interface ISignable
{
    public function serializeForSigning(): string;

    public function applySignature(Signature $signature): void;
}
