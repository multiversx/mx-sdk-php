<?php

namespace MultiversX;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;

class TokenTransfer
{
    protected function __construct(
        public readonly string $tokenId,
        public readonly int $nonce,
        public BigInteger $amountAsBigInteger,
        public readonly int $numDecimals,
    ) {
    }

    public static function egldFromAmount(int|float $amount): TokenTransfer
    {
        $bigInteger = BigDecimal::of($amount)
            ->toScale(Constants::EGLD_DECIMALS, RoundingMode::DOWN)
            ->withPointMovedRight(Constants::EGLD_DECIMALS)
            ->toBigInteger();

        return static::egldFromBigInteger($bigInteger);
    }

    public static function egldFromBigInteger(BigInteger|string $amountAsBigInteger): TokenTransfer
    {
        return new TokenTransfer(Constants::EGLD_TOKEN_ID, 0, BigInteger::of($amountAsBigInteger), Constants::EGLD_DECIMALS);
    }

    public static function fungibleFromAmount(string $tokenIdentifier, int|float $amount, int $numDecimals): TokenTransfer
    {
        $bigInteger = BigDecimal::of($amount)
            ->toScale($numDecimals, RoundingMode::DOWN)
            ->withPointMovedRight($numDecimals)
            ->toBigInteger();

        return static::fungibleFromBigInteger($tokenIdentifier, $bigInteger, $numDecimals);
    }

    public static function fungibleFromBigInteger(string $tokenIdentifier, BigInteger|string $amountAsBigInteger, int $numDecimals = 0): TokenTransfer
    {
        return new TokenTransfer($tokenIdentifier, 0, BigInteger::of($amountAsBigInteger), $numDecimals);
    }

    public static function nonFungible(string $tokenIdentifier, int $nonce): TokenTransfer
    {
        return new TokenTransfer($tokenIdentifier, $nonce, BigInteger::one(), 0);
    }

    public static function semiFungible(string $tokenIdentifier, int $nonce, int $quantity)
    {
        return new TokenTransfer($tokenIdentifier, $nonce, BigInteger::of($quantity), 0);
    }

    public static function metaEsdtFromAmount(string $tokenIdentifier, int $nonce, int|float $amount, int $numDecimals): TokenTransfer
    {
        $bigInteger = BigDecimal::of($amount)
            ->withPointMovedRight($numDecimals)
            ->toBigInteger();

        return static::metaEsdtFromBigInteger($tokenIdentifier, $nonce, $bigInteger, $numDecimals);
    }

    public static function metaEsdtFromBigInteger(string $tokenIdentifier, int $nonce, BigInteger|string $amountAsBigInteger, int $numDecimals = 0)
    {
        return new TokenTransfer($tokenIdentifier, $nonce, BigInteger::of($amountAsBigInteger), $numDecimals);
    }

    public function isEgld()
    {
        return $this->tokenId === Constants::EGLD_TOKEN_ID;
    }

    public function isFungible()
    {
        return $this->nonce === 0;
    }
}
