<?php

namespace MultiversX;

use Exception;
use function BitWasp\Bech32\convertBits;
use function BitWasp\Bech32\decode;
use function BitWasp\Bech32\encode;
use InvalidArgumentException;
use Throwable;

class Address
{
    const DEFAULT_HRP = 'erd';
    const CONTRACT_HEX_PUBKEY_PREFIX = '0000000000000000';
    const BECH32_ADDRESS_LENGTH = 62;
    const PUBKEY_LENGTH = 32;

    private function __construct(
        private string $valueHex,
        public readonly string $hrp = self::DEFAULT_HRP
    ) {
    }

    public static function newFromHex(string $value, string $hrp = self::DEFAULT_HRP): Address
    {
        if (! self::isValidHex($value)) {
            throw new InvalidArgumentException('invalid hex value');
        }

        return new Address(
            $value ?: throw new InvalidArgumentException('hex value is required'),
            $hrp
        );
    }

    public static function newFromBech32(string $address): Address
    {
        if (strlen($address) !== self::BECH32_ADDRESS_LENGTH) {
            throw new Exception('invalid address length');
        }

        [$hrp, $decoded] = decode(strtolower($address));
        $res = convertBits($decoded, count($decoded), 5, 8, false);
        $pieces = array_map(fn ($bits) => dechex($bits), $res);
        $hex = array_reduce($pieces, fn ($carry, $hex) => $carry . str_pad($hex, 2, "0", STR_PAD_LEFT));

        return new Address($hex, $hrp);
    }

    public static function newFromBase64(string $value, string $hrp = self::DEFAULT_HRP): Address
    {
        return new Address(bin2hex(base64_decode($value)), $hrp);
    }

    public static function zero(string $hrp = self::DEFAULT_HRP): Address
    {
        return new Address(str_repeat('0', 64), $hrp);
    }

    public function hex(): string
    {
        return $this->valueHex;
    }

    public function bech32(): string
    {
        $bin = hex2bin($this->valueHex);
        $bits = array_values(unpack('C*', $bin));

        return encode($this->hrp, convertBits($bits, count($bits), 8, 5));
    }

    public function getPublicKey(): PublicKey
    {
        return new PublicKey($this->valueHex);
    }

    public function isSmartContract(): bool
    {
        return str_starts_with($this->valueHex, self::CONTRACT_HEX_PUBKEY_PREFIX);
    }

    /**
     * @deprecated Use {@link isSmartContract} instead.
     */
    public function isContractAddress(): bool
    {
        return $this->isSmartContract();
    }

    public function isZero(): bool
    {
        return $this->valueHex === Address::zero($this->hrp)->valueHex;
    }

    public function equals(?Address $other): bool
    {
        return $other !== null
            ? $this->valueHex === $other->hex()
            : false;
    }

    public function __toString()
    {
        return $this->bech32();
    }

    private static function isValidHex(string $value): bool
    {
        return ctype_xdigit($value) && strlen($value) === 64;
    }

    public static function isValid(string $address): bool
    {
        try {
            $decoded = decode($address);

            [$hrp, $data] = $decoded;
            $pubkey = convertBits($data, count($data), 5, 8, false);

            return $hrp === self::DEFAULT_HRP && count($pubkey) === self::PUBKEY_LENGTH;
        } catch (Throwable $th) {
            return false;
        }
    }

    /**
     * @deprecated Use {@link newFromHex} instead.
     */
    public static function fromHex(string $value, string $hrp = self::DEFAULT_HRP): Address
    {
        return self::newFromHex($value, $hrp);
    }

    /**
     * @deprecated Use {@link newFromBech32} instead.
     */
    public static function fromBech32(string $address): Address
    {
        return self::newFromBech32($address);
    }

    /**
     * @deprecated Use {@link newFromBase64} instead.
     */
    public static function fromBase64(string $value, string $hrp = self::DEFAULT_HRP): Address
    {
        return self::newFromBase64($value, $hrp);
    }
}
