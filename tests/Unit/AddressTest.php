<?php

use MultiversX\Address;

it('should create address from bech32', function () {
    $aliceBech32 = "erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th";
    $aliceHex = "0139472eff6886771a982f3083da5d421f24c29181e63888228dc81ca60d69e1";
    expect(Address::fromBech32($aliceBech32)->hex())->toBe($aliceHex);

    $bobBech32 = "erd1spyavw0956vq68xj8y4tenjpq2wd5a9p2c6j8gsz7ztyrnpxrruqzu66jx";
    $bobHex = "8049d639e5a6980d1cd2392abcce41029cda74a1563523a202f09641cc2618f8";
    expect(Address::fromBech32($bobBech32)->hex())->toBe($bobHex);
});

it('should encode hex to bech32', function ($hex, $expectedBech32) {
    expect(Address::fromHex($hex)->bech32())->toBe($expectedBech32);
})
    ->with([
        ['3a60e0894350221abe5fcbacb2f3cdaebec1f2cd99e4f2ac21177d4ca58f908f', 'erd18fswpz2r2q3p40jlewkt9u7d46lvrukdn8j09tppza75efv0jz8s2lc68r'],
        ['8ebc2a357392def5c610be043671d4d4f77ca18bd4f8aa0929bf9c663c81012d', 'erd1367z5dtnjt00t3sshczrvuw56nmhegvt6nu25zffh7wxv0ypqykshauu5q'],
        ['012db20c19df2f1294f2734abf473c7e3279f1a24f9626e73f18c7cd15a072d5', 'erd1qykmyrqemuh3998jwd9t73eu0ce8nudzf7tzdeelrrru69dqwt2scrsz7k'],
        ['2618b0d4cf214d90bee9cb72cdd41fa93cc71b8e06e8becbda9c74776a0f57db', 'erd1ycvtp4x0y9xep0hfedevm4ql4y7vwxuwqm5taj76n368w6s02ldsfpd3au'],
    ]);

it('should create empty address', function () {
    $emptyAddress = new Address("");
    expect($emptyAddress->hex())->toBe('');
    expect($emptyAddress->bech32())->toBe('');
});

it('isContractAddress - returns true for contract addresses', fn ($bech32) => expect(Address::fromBech32($bech32)->isContractAddress())->toBeTrue())
    ->with([
        'erd1qqqqqqqqqqqqqqqpqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqplllst77y4l',
        'erd1qqqqqqqqqqqqqpgqhe8t5jewej70zupmh44jurgn29psua5l2jps3ntjj3',
        'erd1qqqqqqqqqqqqqpgqmuk0q2saj0mgutxm4teywre6dl8wqf58xamqdrukln',
    ]);

it('isContractAddress - returns false for normal addresses', fn ($bech32) => expect(Address::fromBech32($bech32)->isContractAddress())->toBeFalse())
    ->with([
        'erd1rf4hv70arudgzus0ymnnsnc4pml0jkywg2xjvzslg0mz4nn2tg7q7k0t6p',
        'erd1ff377y7qdldtsahvt28ec45zkyu0pepuup33adhr8wr2yuelwv7qpevs9e',
        'erd1vup7q384decm8l8mu4ehz75c5mfs089nd32fteru95tm8d0a8dqs8g0yst',
    ]);

it('zero - returns the zero address', fn () => expect(Address::zero()->bech32())->toBe('erd1qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq6gq4hu'));

it('isZero - returns true for a zero address', fn () => expect(Address::zero()->isZero())->toBeTrue());

it('equals - should check equality of addresses', function () {
    $alice = new Address("erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th");
    $aliceSame = new Address("0139472eff6886771a982f3083da5d421f24c29181e63888228dc81ca60d69e1");
    $bob = new Address("erd1spyavw0956vq68xj8y4tenjpq2wd5a9p2c6j8gsz7ztyrnpxrruqzu66jx");

    expect($alice->equals($aliceSame))->toBeTrue();
    expect($aliceSame->equals($alice))->toBeTrue();
    expect($bob->equals($alice))->toBeFalse();
});
