<?php

namespace MultiversX;

use MultiversX\Interfaces\IPublicKey;

final class UserVerifier
{
    public function __construct(
        private string $publicKey,
    ) {
    }

    public static function fromAddress(Address $address): UserVerifier
    {
        return new UserVerifier($address->hex());
    }

    public function verify(Bytes $data, Bytes $signature, IPublicKey $publicKey): bool
    {
        return sodium_crypto_sign_verify_detached(
            signature: sodium_hex2bin($signature->hex),
            message: sodium_hex2bin($data->hex),
            public_key: sodium_hex2bin($publicKey->getBytes()->hex),
        );
    }
}
