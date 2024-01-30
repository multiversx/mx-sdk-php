<?php

use MultiversX\Http\Api\Endpoints\TokenEndpoints;

it('getById - gets the token', function () {
    $client = createMockedHttpClientWithResponse('tokens/token.json');

    $actual = (new TokenEndpoints($client))
        ->getById('SUPER-764d8d');

    assertMatchesResponseSnapshot($actual);
});

it('getTokens - gets tokens', function () {
    $client = createMockedHttpClientWithResponse('tokens/tokens.json');

    $actual = (new TokenEndpoints($client))
        ->getTokens();

    assertMatchesResponseSnapshot($actual);
});

it('getAccounts - gets the token accounts', function () {
    $client = createMockedHttpClientWithResponse('tokens/accounts.json');

    $actual = (new TokenEndpoints($client))
        ->getAccounts('SUPER-764d8d');

    assertMatchesResponseSnapshot($actual);
});

it('getAccountsCount - gets the token accounts count', function () {
    $client = createMockedHttpClientWithResponse('/tokens/SUPER-764d8d/accounts/count', 2343);

    $actual = (new TokenEndpoints($client))
        ->getAccountsCount('SUPER-764d8d');

    assertMatchesResponseSnapshot($actual);
});

it('getTransactions - gets the transaction history of an NFT ', function () {
    $client = createMockedHttpClientWithResponse('tokens/transactions.json');

    $actual = (new TokenEndpoints($client))
        ->getTransactions('QUACK-f01e02-0259');

    assertMatchesResponseSnapshot($actual);
});

it('getRoles - gets the token roles', function () {
    $client = createMockedHttpClientWithResponse('tokens/roles.json');

    $actual = (new TokenEndpoints($client))
        ->getRoles('SUPER-764d8d');

    assertMatchesResponseSnapshot($actual);
});
