<?php

namespace MultiversX;

use kornrunner\Keccak;
use MultiversX\Interfaces\IVerifiable;

final class SignableMessage implements IVerifiable
{
    const MESSAGE_PREFIX = "\x17Elrond Signed Message:\n";

    public function __construct(
        public string $message,
        public Signature $signature,
        public Address $address,
    ) {
    }

    public function serializeForSigning(): string
    {
        return Keccak::hash(static::MESSAGE_PREFIX . strlen($this->message) . $this->message, 256);
    }

    public function getSignature(): Signature
    {
        return $this->signature;
    }
}
