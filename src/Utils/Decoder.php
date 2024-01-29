<?php

namespace MultiversX\Utils;

use Brick\Math\BigInteger;

class Decoder
{
    public static function fromBase64ToInt(string $value): int
    {
        return hexdec(bin2hex(base64_decode($value)));
    }

    public static function fromBase64ToBigInteger(string $value): BigInteger
    {
        $decodedHex = bin2hex(base64_decode($value));

        return static::bchexdec($decodedHex);
    }

    public static function bchexdec(string $hex): BigInteger
    {
        $decBig = 0;
        $len = strlen($hex);

        for ($i = 1; $i <= $len; $i++) {
            $decBig = bcadd($decBig, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
        }

        return BigInteger::of($decBig);
    }
}
