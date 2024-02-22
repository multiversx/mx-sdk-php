<?php

use MultiversX\Http\Api\Endpoints\DexEndpoints;

it('gets dex pairs', function () {
    $client = createMockedHttpClientWithResponse('mex/pairs.json');

    $actual = (new DexEndpoints($client))
        ->getPairs();

    assertMatchesResponseSnapshot($actual);
});

it('gets mex tokens', function () {
    $client = createMockedHttpClientWithResponse('mex/tokens.json');

    $actual = (new DexEndpoints($client))
        ->getTokens();

    assertMatchesResponseSnapshot($actual);
});
