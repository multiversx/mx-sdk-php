<?php

use Brick\Math\BigInteger;
use MultiversX\TokenTransfer;

it('should work with EGLD', function () {
    expect(TokenTransfer::egldFromAmount(1)->amountAsBigInteger)->toEqual(BigInteger::of("1000000000000000000"));
    expect(TokenTransfer::egldFromAmount(10)->amountAsBigInteger)->toEqual(BigInteger::of("10000000000000000000"));
    expect(TokenTransfer::egldFromAmount(100)->amountAsBigInteger)->toEqual(BigInteger::of("100000000000000000000"));
    expect(TokenTransfer::egldFromAmount(1000)->amountAsBigInteger)->toEqual(BigInteger::of("1000000000000000000000"));
    expect(TokenTransfer::egldFromAmount(0.1)->amountAsBigInteger)->toEqual(BigInteger::of("100000000000000000"));
    expect(TokenTransfer::egldFromAmount(0.123456789)->amountAsBigInteger)->toEqual(BigInteger::of("123456789000000000"));
    expect(TokenTransfer::egldFromAmount(0.123456789123456789)->amountAsBigInteger)->toEqual(BigInteger::of("123456789123460000"));
    expect(TokenTransfer::egldFromAmount(0.123456789123456789777)->amountAsBigInteger)->toEqual(BigInteger::of("123456789123460000"));
    expect(TokenTransfer::egldFromBigInteger("1")->amountAsBigInteger)->toEqual(BigInteger::of("1"));
    expect(TokenTransfer::egldFromAmount("1")->isEgld())->toBeTrue();
});

it('should work with USDC', function () {
    $identifier = "USDC-c76f1f";
    $numDecimals = 6;
    expect(TokenTransfer::fungibleFromAmount($identifier, "1", $numDecimals)->amountAsBigInteger)->toEqual(BigInteger::of("1000000"));
    expect(TokenTransfer::fungibleFromAmount($identifier, "0.1", $numDecimals)->amountAsBigInteger)->toEqual(BigInteger::of("100000"));
    expect(TokenTransfer::fungibleFromAmount($identifier, "0.123456789", $numDecimals)->amountAsBigInteger)->toEqual(BigInteger::of("123456"));
    expect(TokenTransfer::fungibleFromBigInteger($identifier, "1000000", $numDecimals)->amountAsBigInteger)->toEqual(BigInteger::of("1000000"));
});

it('should work with MetaESDT', function () {
    $identifier = "MEXFARML-28d646";
    $numDecimals = 18;
    $nonce = 12345678;
    $transfer = TokenTransfer::metaEsdtFromAmount($identifier, $nonce, "0.1", $numDecimals);
    expect($transfer->tokenId)->toBe($identifier);
    expect($transfer->nonce)->toBe($nonce);
    expect($transfer->amountAsBigInteger)->toEqual(BigInteger::of("100000000000000000"));
});

it('should work with NFTs', function () {
    $identifier = "TEST-38f249";
    $nonce = 1;
    $transfer = TokenTransfer::nonFungible($identifier, $nonce);
    expect($transfer->tokenId)->toBe($identifier);
    expect($transfer->nonce)->toBe($nonce);
    expect($transfer->amountAsBigInteger)->toEqual(BigInteger::one());
});
