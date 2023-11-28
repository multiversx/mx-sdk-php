<?php

namespace MultiversX;

use Exception;
use Elliptic\EdDSA;
use Illuminate\Support\Collection;

class UserSecretKey
{
    const USER_SEED_LENGTH = 32;
    const USER_PUBKEY_LENGTH = 32;

    private function __construct(
        public readonly string $key,
    ) {
    }

    public static function fromPem(string $text, int $index = 0): UserSecretKey
    {
        return static::parseUserKeysFromPem($text)[$index];
    }

    public function sign(string $message): string
    {
        return (new EdDSA('ed25519'))
            ->keyFromSecret($this->key)
            ->sign($message)
            ->toHex();
    }

    private static function parseUserKeysFromPem(string $text): Collection
    {
        return static::parsePem($text, static::USER_SEED_LENGTH + static::USER_PUBKEY_LENGTH)
            ->map(fn (string $buffer) => new UserSecretKey(bin2hex(substr($buffer, 0, static::USER_SEED_LENGTH))));
    }

    private static function parsePem(string $text, int $expectedLength): Collection
    {
        // converted from https://github.com/multiversx/mx-sdk-js-wallet/blob/main/src/pem.ts
        $lines = array_filter(array_map('trim', preg_split('/\r?\n/', $text)));
        $buffers = collect();
        $linesAccumulator = collect();

        foreach ($lines as $line) {
            if (str_starts_with($line, '-----BEGIN')) {
                $linesAccumulator = collect();
            } elseif (str_starts_with($line, '-----END')) {
                $asBase64 = $linesAccumulator->join('');
                $asHex = base64_decode($asBase64);
                $asBytes = hex2bin($asHex);

                if (strlen($asBytes) !== $expectedLength) {
                    throw new Exception("incorrect key length: expected $expectedLength, found".strlen($asBytes));
                }

                $buffers->push($asBytes);
                $linesAccumulator = collect();
            } else {
                $linesAccumulator->push($line);
            }
        }

        if ($linesAccumulator->isNotEmpty()) {
            throw new Exception("incorrect file structure");
        }

        return $buffers;
    }
}
