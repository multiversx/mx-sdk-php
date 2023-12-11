<?php

namespace MultiversX\Utils;

use Brick\Math\BigInteger;
use MultiversX\Address;

class Encoder
{
    public static function toHex(string|int|BigInteger|Address $value): string
    {
        if (is_string($value)) {
            return str_starts_with($value, Address::HRP)
                ? Address::fromBech32($value)->hex()
                : bin2hex(trim($value));
        }

        if ($value instanceof BigInteger) {
            return bin2hex($value->toBytes(signed: false));
        }

        if ($value instanceof Address) {
            return $value->hex();
        }

        return static::toPaddedHex(dechex($value));
    }

    public static function toPaddedHex(string|int $value): string
    {
        return strlen($value) % 2 === 1 ? '0' . $value : $value;
    }
}
