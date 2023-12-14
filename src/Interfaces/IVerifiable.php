<?php

namespace MultiversX\Interfaces;

use MultiversX\Signature;

interface IVerifiable
{
    public function serializeForSigning(): string;

    public function getSignature(): Signature;
}
