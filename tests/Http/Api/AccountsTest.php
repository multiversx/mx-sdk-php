<?php

use Brick\Math\BigInteger;
use MultiversX\Http\Api\Endpoints\AccountEndpoints;
use MultiversX\Http\Entities\Nft;

it('getByAddress - gets an account by address', function () {
    $client = createMockedHttpClientWithResponse('accounts/account.json');

    $actual = (new AccountEndpoints($client))
        ->getByAddress('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc');

    expect($actual->balance)->toBeInstanceOf(BigInteger::class);

    assertMatchesResponseSnapshot($actual);
});

it('getNfts - gets an accounts nfts', function () {
    $client = createMockedHttpClientWithResponse('accounts/nfts.json');

    $actual = (new AccountEndpoints($client))
        ->getNfts('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc');

    assertMatchesResponseSnapshot($actual);

    expect($actual[0])->toBeInstanceOf(Nft::class);
    expect(base64_decode($actual[0]->attributes))->toBe("description:POWERED BY ELROND NETWORK"); // to be base64 decoded
});

it('getTokens - gets tokens owned by an account', function () {
    $client = createMockedHttpClientWithResponse('accounts/tokens.json');

    $actual = (new AccountEndpoints($client))
        ->getTokens('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc');

    assertMatchesResponseSnapshot($actual);
});

it('getToken - gets a specifc token owned by an account', function () {
    $client = createMockedHttpClientWithResponse('accounts/token-with-balance.json');

    $actual = (new AccountEndpoints($client))
        ->getToken('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc', 'WHALE-b018f0');

    assertMatchesResponseSnapshot($actual);

    expect($actual->balance)->toBeInstanceOf(BigInteger::class);
    expect((string) $actual->balance)->toBe("1000000000000");
});

it('getCollections - gets collections owned by the user', function () {
    $client = createMockedHttpClientWithResponse('accounts/collections.json');

    $actual = (new AccountEndpoints($client))
        ->getCollections('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc');

    assertMatchesResponseSnapshot($actual);
});

it('getCollection - gets collection owned by the user and given id', function () {
    $client = createMockedHttpClientWithResponse('accounts/collection.json');

    $actual = (new AccountEndpoints($client))
        ->getCollection('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc', 'EVOLUTIONS-570eff');

    assertMatchesResponseSnapshot($actual);
});

it('getRolesCollections - gets role collections owned by the user', function () {
    $client = createMockedHttpClientWithResponse('accounts/role-collections.json');

    $actual = (new AccountEndpoints($client))
        ->getRolesCollections('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc');

    assertMatchesResponseSnapshot($actual);
});

it('getRolesCollection - gets collection owned by the user and given id', function () {
    $client = createMockedHttpClientWithResponse('accounts/role-collection.json');

    $actual = (new AccountEndpoints($client))
        ->getRolesCollection('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc', 'SING-3c59b4');

    assertMatchesResponseSnapshot($actual);
});

it('getTransactions - gets transactions of an account', function () {
    $client = createMockedHttpClientWithResponse('accounts/transactions.json');

    $actual = (new AccountEndpoints($client))
        ->getTransactions('erd1660va6y429mxz4dkgek0ssny8tccaaaaaaaaaabbbbbbbbbbcccccccccc');

    assertMatchesResponseSnapshot($actual);
});
