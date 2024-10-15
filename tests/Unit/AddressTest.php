<?php

use MultiversX\Address;

it('should create address', function () {
    $aliceBech32 = "erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th";
    $bobBech32 = "erd1spyavw0956vq68xj8y4tenjpq2wd5a9p2c6j8gsz7ztyrnpxrruqzu66jx";
    $aliceHex = "0139472eff6886771a982f3083da5d421f24c29181e63888228dc81ca60d69e1";
    $bobHex = "8049d639e5a6980d1cd2392abcce41029cda74a1563523a202f09641cc2618f8";

    expect(Address::newFromBech32($aliceBech32)->hex())->toBe($aliceHex);
    expect(Address::newFromBech32($bobBech32)->hex())->toBe($bobHex);

    expect(Address::newFromHex($aliceHex)->hex())->toBe($aliceHex);
    expect(Address::newFromHex($bobHex)->hex())->toBe($bobHex);
});

it('should create address with custom hrp', function () {
    $aliceHex = "0139472eff6886771a982f3083da5d421f24c29181e63888228dc81ca60d69e1";
    $bobHex = "8049d639e5a6980d1cd2392abcce41029cda74a1563523a202f09641cc2618f8";

    $address = Address::newFromHex($aliceHex, "test");
    expect($address->hex())->toBe($aliceHex);
    expect($address->hrp)->toBe("test");
    expect($address->bech32())->toBe("test1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ss5hqhtr");

    $address = Address::newFromHex($bobHex, "xerd");
    expect($address->hex())->toBe($bobHex);
    expect($address->hrp)->toBe("xerd");
    expect($address->bech32())->toBe("xerd1spyavw0956vq68xj8y4tenjpq2wd5a9p2c6j8gsz7ztyrnpxrruq9thc9j");
});

it('should create a zero address', function () {
    $nobody = Address::zero();

    expect($nobody->hex())->toBe('0000000000000000000000000000000000000000000000000000000000000000');
    expect($nobody->bech32())->toBe('erd1qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq6gq4hu');
});

it('should check equality', function () {
    $aliceBech32 = "erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th";
    $aliceHex = "0139472eff6886771a982f3083da5d421f24c29181e63888228dc81ca60d69e1";
    $bobBech32 = "erd1spyavw0956vq68xj8y4tenjpq2wd5a9p2c6j8gsz7ztyrnpxrruqzu66jx";

    $aliceFoo = Address::newFromBech32($aliceBech32);
    $aliceBar = Address::newFromHex($aliceHex);
    $bob = Address::newFromBech32($bobBech32);

    expect($aliceFoo->equals($aliceBar))->toBeTrue();
    expect($aliceBar->equals($aliceFoo))->toBeTrue();
    expect($aliceFoo->equals($aliceFoo))->toBeTrue();
    expect($bob->equals($aliceBar))->toBeFalse();
    expect($bob->equals(null))->toBeFalse();
});

it('should throw error when invalid input', function () {
    expect(fn() => Address::newFromHex("foo"))->toThrow(InvalidArgumentException::class);
    expect(fn() => Address::newFromHex("a".str_repeat("a", 7)))->toThrow(InvalidArgumentException::class);
    expect(fn() => Address::newFromHex("aaaa"))->toThrow(InvalidArgumentException::class);
    expect(fn() => Address::newFromBech32("erd1l453hd0gt5gzdp7czpuall8ggt2dcv5zwmfdf3sd3lguxseux2"))->toThrow(Exception::class);
    expect(fn() => Address::newFromBech32("xerd1l453hd0gt5gzdp7czpuall8ggt2dcv5zwmfdf3sd3lguxseux2fsmsgldz"))->toThrow(Exception::class);
});

it('should validate the address without throwing the error', function () {
    expect(Address::isValid("erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th"))->toBeTrue();
    expect(Address::isValid("xerd1l453hd0gt5gzdp7czpuall8ggt2dcv5zwmfdf3sd3lguxseux2fsmsgldz"))->toBeFalse();
    expect(Address::isValid("erd1l453hd0gt5gzdp7czpuall8ggt2dcv5zwmfdf3sd3lguxseux2"))->toBeFalse();
});

it('should check whether isSmartContract', function () {
    expect(Address::newFromBech32("erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th")->isSmartContract())->toBeFalse();
    expect(Address::newFromBech32("erd1qqqqqqqqqqqqqqqpqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqplllst77y4l")->isSmartContract())->toBeTrue();
    expect(Address::newFromBech32("erd1qqqqqqqqqqqqqpgqxwakt2g7u9atsnr03gqcgmhcv38pt7mkd94q6shuwt")->isSmartContract())->toBeTrue();
});
